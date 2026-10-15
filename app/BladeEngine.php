<?php

namespace App;

class BladeEngine
{
    protected string $viewsPath;
    protected string $cachePath;
    protected array $sections = [];
    protected ?string $layout = null;

    public function __construct(string $viewsPath, string $cachePath)
    {
        $this->viewsPath = rtrim($viewsPath, '/');
        $this->cachePath = rtrim($cachePath, '/');
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0777, true);
        }
    }

    public function render(string $view, array $data = []): string
    {
        $this->sections = [];
        $this->layout = null;

        $viewPath = $this->resolveViewPath($view);
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$view} (path: {$viewPath})");
        }

        $content = file_get_contents($viewPath);
        $compiled = $this->compile($content);

        // Execute template in isolated scope
        ob_start();
        extract($data);
        eval('?>' . $compiled);
        $output = ob_get_clean();

        // If template extended a layout, render layout with injected sections
        if ($this->layout) {
            $layoutPath = $this->resolveViewPath($this->layout);
            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout not found: {$this->layout} (path: {$layoutPath})");
            }
            $layoutContent = file_get_contents($layoutPath);
            $compiledLayout = $this->compileLayout($layoutContent);

            ob_start();
            extract($data);
            eval('?>' . $compiledLayout);
            return ob_get_clean();
        }

        return $output;
    }

    protected function resolveViewPath(string $view): string
    {
        $normalized = str_replace('.', '/', $view);
        return $this->viewsPath . '/' . $normalized . '.blade.php';
    }

    protected function compile(string $content): string
    {
        // 1. Extract @extends('...')
        if (preg_match('/@extends\([\'"]([^\'"]+)[\'"]\)/', $content, $matches)) {
            $this->layout = $matches[1];
            $content = str_replace($matches[0], '', $content);
        }

        // 2. Extract single line @section('name', 'value')
        $content = preg_replace_callback('/@section\([\'"]([^\'"]+)[\'"],\s*[\'"]([^\'"]*)[\'"]\)/', function ($m) {
            $this->sections[$m[1]] = htmlspecialchars($m[2]);
            return '';
        }, $content);

        // 3. Extract block @section('name') ... @endsection
        $content = preg_replace_callback('/@section\([\'"]([^\'"]+)[\'"]\)(.*?)@endsection/s', function ($m) {
            $this->sections[$m[1]] = $m[2];
            return '';
        }, $content);

        // Handle remaining content (if any outside sections)
        return $this->compileDirectives($content);
    }

    protected function compileLayout(string $content): string
    {
        // Replace @yield('name', 'default') with section content
        $content = preg_replace_callback('/@yield\([\'"]([^\'"]+)[\'"](?:,\s*[\'"]([^\'"]*)[\'"])?\)/', function ($m) {
            $name = $m[1];
            $default = $m[2] ?? '';
            $sectionContent = $this->sections[$name] ?? $default;
            return $this->compileDirectives($sectionContent);
        }, $content);

        return $this->compileDirectives($content);
    }

    protected function compileDirectives(string $content): string
    {
        // Strip Blade comments: {{-- ... --}}
        $content = preg_replace('/\{\{--.*?--\}\}/s', '', $content);
        // @include('subview')
        $content = preg_replace_callback('/@include\([\'"]([^\'"]+)[\'"]\)/', function ($m) {
            $subPath = $this->resolveViewPath($m[1]);
            if (file_exists($subPath)) {
                $subContent = file_get_contents($subPath);
                return $this->compileDirectives($subContent);
            }
            return '<!-- Include not found: ' . htmlspecialchars($m[1]) . ' -->';
        }, $content);

        // @csrf
        $content = preg_replace('/@csrf/', '<input type="hidden" name="_token" value="electrostore_csrf_demo_token">', $content);

        // @method('PUT')
        $content = preg_replace_callback('/@method\([\'"]([^\'"]+)[\'"]\)/', function ($m) {
            return '<input type="hidden" name="_method" value="' . htmlspecialchars($m[1]) . '">';
        }, $content);

        // Blade echoes
        // Unescaped: {!! $var !!}
        $content = preg_replace('/\{!!\s*(.+?)\s*!!\}/s', '<?php echo $1; ?>', $content);
        // Escaped: {{ $var }}
        $content = preg_replace('/\{\{\s*(.+?)\s*\}\}/s', '<?php echo htmlspecialchars((string)($1 ?? ""), ENT_QUOTES, "UTF-8"); ?>', $content);

        // Conditionals with nested parenthesis support
        $content = preg_replace('/@if\s*(\((?:[^()]|(?1))*\))/', '<?php if $1: ?>', $content);
        $content = preg_replace('/@elseif\s*(\((?:[^()]|(?1))*\))/', '<?php elseif $1: ?>', $content);
        $content = preg_replace('/@else/', '<?php else: ?>', $content);
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);

        // Loops with nested parenthesis support
        $content = preg_replace('/@foreach\s*(\((?:[^()]|(?1))*\))/', '<?php foreach $1: ?>', $content);
        $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);
        $content = preg_replace('/@for\s*(\((?:[^()]|(?1))*\))/', '<?php for $1: ?>', $content);
        $content = preg_replace('/@endfor/', '<?php endfor; ?>', $content);

        // Raw PHP
        $content = preg_replace('/@php/', '<?php ', $content);
        $content = preg_replace('/@endphp/', ' ?>', $content);

        return $content;
    }
}
