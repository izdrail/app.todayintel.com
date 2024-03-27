<x-waterhole::cp :title="__('waterhole::cp.dashboard-title')">
    <div class="">
        <div id="trending-app" :baseUrl="<?php echo url('/');?>"></div>
        <script src="{{ asset('js/trending-app.js') }}"></script>
    </div>
</x-waterhole::cp>
<style>
    .cp__content{
        max-width:100% !important;
    }
</style>
