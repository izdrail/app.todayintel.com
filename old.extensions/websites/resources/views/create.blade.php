<x-waterhole::cp>
    <form method="post" action="{{ route('waterhole.cp.websites.store') }}">
        <div class="stack dividers">
            <x-waterhole::field
                    name="domain"
                    label="Domain"
                    description="Enter the wordpress website address."
                    placeholder="https://example.com">
                <input type="text" name="domain">
            </x-waterhole::field>
            <x-waterhole::field
                    name="username"
                    label="Username"
                    description="Enter the admin username."
                    placeholder="admin">
                <input type="text" name="username">
            </x-waterhole::field>
            <x-waterhole::field
                    name="password"
                    label="Password"
                    description="Enter the admin password."
                    placeholder="admin">
                <input type="password" name="password">
            </x-waterhole::field>

            <button class="btn">
                @icon('tabler-send')
                Submit
            </button>
        </div>
    </form>

</x-waterhole::cp>