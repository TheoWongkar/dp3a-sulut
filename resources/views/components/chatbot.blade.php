<!-- Chat Bot -->
<div x-data="{ open: false }" @open-chat.window="open = true" class="fixed bottom-4 right-4 z-20">
    <!-- Chat Icon -->
    <div x-show="!open" @click="open = true"
        class="cursor-pointer bg-blue-700 hover:bg-[#141652] text-white p-2 rounded-full shadow-lg">
        <img src="{{ asset('img/chatbot-logo.png') }}" alt="Chatbot" class="size-12">
    </div>

    <!-- Chat Widget -->
    <div x-cloak x-show="open" class="w-80 h-80 bg-white rounded-lg shadow-lg flex flex-col border border-gray-500">
        <!-- Chat Header -->
        <div class="bg-[#141652] hover:bg-blue-700 text-white p-3 rounded-t-lg cursor-pointer" @click="open = false">
            <h4 class="font-bold">DP3A Chatbot</h4>
        </div>

        <!-- Chat Container -->
        <div id="chat-container" class="flex-1 p-4 space-y-3 max-h-64 overflow-y-auto">
            <!-- Messages will appear here -->
        </div>

        <form id="chat-form" class="p-2 border-t">
            <div class="flex items-center space-x-2">
                <textarea id="message"
                    class="flex-1 border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-none resize-none overflow-hidden"
                    placeholder="Tanyakan sesuatu..." rows="1" autocomplete="off"></textarea>
                <button type="submit"
                    class="bg-[#141652] border border-[#141652] text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path
                            d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
