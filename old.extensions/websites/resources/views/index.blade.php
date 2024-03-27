<x-waterhole::cp>
    <section class="with-sidebar">
        <div class="card p-sm">
            <h3>
                Create Website Connections
            </h3>
            <p>
                This are the websites you can connect to publish your content.
            </p>
            <small>
                We are currently supporting: Wordpress, Git Publish, and FTP.
            </small>
        </div>
        <nav class="sidebar">
            <a class="btn bg-success" href="{{ route('waterhole.cp.websites.create') }}">
                @icon('tabler-plus')
                Add Website
            </a>
        </nav>


    </section>

</x-waterhole::cp>