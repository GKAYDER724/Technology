<div class="chat-layout">

    <div class="chat-box">

        <div class="chat-header">

            <a href="{{ url('/') }}" class="back-btn">←</a>

            <div class="header-center">

                <div class="header-title">
                    Hỗ trợ ElectroTech
                </div>


                @if($admin && $admin->last_seen)

                    @if($admin->last_seen->diffInMinutes(now()) < 5)

                        <div class="status-online">
                            🟢 Đang online
                        </div>

                    @else

                        <div class="status-offline">
                            ⚪ {{ $admin->last_seen->diffForHumans() }}
                        </div>

                    @endif

                @endif


            </div>

        </div>



        <div class="messages" id="messages">


            @foreach($messages as $message)


                            <div class="message {{ $message->sender == 'customer' ? 'right' : 'left' }}" data-id="{{ $message->chat_message_id }}">


                                <div class="bubble {{ 
                $message->sender == 'customer'
                        ? 'customer'
                        : ($message->sender == 'ai' ? 'ai' : 'admin') 
                }}">
                                    @if($message->sender == 'ai')

                                        🤖 {{ $message->message }}

                                    @else

                                        {{ $message->message }}

                                    @endif



                                    <small>
                                        {{ $message->created_at->format('H:i:s d/m/Y') }}
                                    </small>


                                </div>


                            </div>


            @endforeach


        </div>



        <form method="POST" action="{{ route('chat.store') }}" class="send-box">

            @csrf


            <input type="text" name="message" placeholder="Nhập tin nhắn...">


            <button type="submit">
                Gửi
            </button>


        </form>

    </div>

</div>



<style>
    * {
        box-sizing: border-box;
    }


    body {
        margin: 0;
        background: #f3f4f6;
        font-family: Arial, Helvetica, sans-serif;
    }


    .chat-layout {
        display: flex;
        justify-content: center;
        margin: 40px auto;
    }


    .chat-box {
        width: 750px;
        height: 720px;
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
    }


    .chat-header {
        height: 80px;
        background: #0d84ff;
        color: #fff;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .back-btn {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        text-decoration: none;
        color: #fff;
        font-size: 42px;
        font-weight: bold;
    }


    .header-center {
        text-align: center;
    }


    .header-title {
        font-size: 24px;
        font-weight: 700;
        font-family: "Times New Roman", serif;
    }


    .status-online,
    .status-offline {
        margin-top: 4px;
        font-size: 12px;
    }


    .status-online {
        color: #d6ffd8;
    }


    .status-offline {
        color: #ececec;
    }



    .messages {
        height: 560px;
        overflow-y: auto;
        padding: 24px;
        background: #f7f7f7;
    }



    .message {
        margin-bottom: 14px;
    }


    .left {
        text-align: left;
    }


    .right {
        text-align: right;
    }



    .bubble {
        display: inline-block;
        max-width: 70%;
        padding: 12px 18px;
        border-radius: 20px;
        word-break: break-word;
    }



    .customer {
        background: #0d84ff;
        color: #fff;
    }



    .admin {
        background: #e8e8e8;
        color: #111;
    }



    .ai {
        background: #fef3c7;
        color: #92400e;
    }



    small {
        display: block;
        margin-top: 6px;
        font-size: 11px;
    }



    .send-box {
        height: 80px;
        display: flex;
        gap: 10px;
        padding: 15px;
        background: #fff;
        border-top: 1px solid #eee;
    }



    .send-box input[type="text"] {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 30px;
        padding: 0 20px;
        font-size: 16px;
    }



    .send-box button {
        border: none;
        background: #0d84ff;
        color: #fff;
        border-radius: 30px;
        padding: 0 28px;
        cursor: pointer;
        font-size: 16px;
    }
</style>



<script>

    let box = document.getElementById("messages");

    let lastMessageId = 0;


    // Lấy id tin nhắn cuối đang có
    let currentMessages = document.querySelectorAll(".message");

    if (currentMessages.length > 0) {

        let last = currentMessages[currentMessages.length - 1];

        lastMessageId = Number(last.dataset.id);

    }


    // Cuộn xuống lúc mở chat

    if (box) {

        box.scrollTop = box.scrollHeight;

    }




    function createMessage(message) {


        let senderClass = "admin";


        if (message.sender === "customer") {

            senderClass = "customer";

        }
        else if (message.sender === "ai") {

            senderClass = "ai";

        }



        return `

    <div class="message ${message.sender === "customer" ? "right" : "left"}"
         data-id="${message.chat_message_id}">


        <div class="bubble ${senderClass}">

            ${message.sender === "ai" ? "🤖 " : ""}${message.message ?? ""}


            <small>

            ${new Date(message.created_at)
                .toLocaleString('vi-VN')}

            </small>


        </div>


    </div>

    `;

    }





    function reloadChat() {


        fetch("{{ route('chat.messages') }}")

            .then(response => response.json())

            .then(data => {
                data.sort((a,b)=>a.chat_message_id-b.chat_message_id);

                data.forEach(message => {


                    // Chỉ lấy tin nhắn mới

                    if (message.chat_message_id > lastMessageId) {


                        let isBottom =
                            box.scrollHeight -
                            box.scrollTop -
                            box.clientHeight < 100;



                        box.insertAdjacentHTML(
                            "beforeend",
                            createMessage(message)
                        );



                        lastMessageId = message.chat_message_id;



                        // Nếu đang ở cuối thì tự xuống

                        if (isBottom) {

                            box.scrollTop = box.scrollHeight;

                        }


                    }


                });



            })


            .catch(error => {

                console.log("Lỗi tải chat:", error);

            });


    }





    setInterval(reloadChat, 3000);


</script>