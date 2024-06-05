@extends('welcome')

@section('content')

    <div class="container mx-auto">
    
        <h1 class="text-2xl font-bold mb-4">Latest News</h1>
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Keyword</label>
            <input type="text" id="keyword" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2" placeholder="Search by keyword" autocomplete="off">
        </div>

        <div class="mb-4">
            <div class="row inline-flex">
                <div class="col-md-3">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2" placeholder="Search by title" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                    <input type="text" id="source" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2" placeholder="Search by source" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                    <input type="text" id="author" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2" placeholder="Search by author" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <label for="publishedAt" class="block text-sm font-medium text-gray-700">Published At</label>
                    <input type="text" id="publishedAt" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2" placeholder="Date" autocomplete="off" readonly>
                </div>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" id="toggleTitle" checked>
                <span class="ml-2">Title</span>
            </label>
            <label class="inline-flex items-center ml-4">
                <input type="checkbox" id="toggleSource" checked>
                <span class="ml-2">Source</span>
            </label>
            <label class="inline-flex items-center ml-4">
                <input type="checkbox" id="togglePublishedAt" checked>
                <span class="ml-2">Published At</span>
            </label>
            <label class="inline-flex items-center ml-4">
                <input type="checkbox" id="toggleAuthor" checked>
                <span class="ml-2">Author</span>
            </label>
            <label class="inline-flex items-center ml-4">
                <input type="checkbox" id="toggleDescription" checked>
                <span class="ml-2">Description</span>
            </label>
        </div>

        <div class="overflow-x-auto">
            <table id="example" class="min-w-full border-collapse table-auto">
                <thead>
                    <tr>
                        <th class="border border-gray-400 px-4 py-2">Title</th>
                        <th class="border border-gray-400 px-4 py-2">Source</th>
                        <th class="border border-gray-400 px-4 py-2">Published At</th>
                        <th class="border border-gray-400 px-4 py-2">Author</th>
                        <th class="border border-gray-400 px-4 py-2">Description</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('after-scripts')
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:"{{ route('news.list') }}",
                        data: function (d) {
                            d.keyword = $('#keyword').val(),
                            d.title = $('#title').val(),
                            d.source = $('#source').val(),
                            d.publishedAt = $('#publishedAt').val(),
                            d.author = $('#author').val()
                        }
                    },
                    columns: [
                        {data: 'title', name: 'title'},
                        {data: 'source', name: 'source'},
                        {data: 'published_at', name: 'published_at'},
                        {data: 'author', name: 'author'},
                        {data: 'description', name: 'description'},
                    ]
        });
        $('#keyword').keyup(function() {
            table.search($(this).val()).draw();
        });
        $('#title').keyup(function() {
            table.search($(this).val()).draw();
        });
        $('#source').keyup(function() {
            table.search($(this).val()).draw();
        });
        $('#publishedAt').change(function() {
            table.search($(this).val()).draw();
        });
        $("#author").keyup(function(){
            table.search($(this).val()).draw();
        });
        $('#toggleTitle').change(function() {
            var column = table.column(0);
            column.visible($(this).is(':checked'));
        });
        $('#toggleSource').change(function() {
            var column = table.column(1);
            column.visible($(this).is(':checked'));
        });
        $('#togglePublishedAt').change(function() {
            var column = table.column(2);
            column.visible($(this).is(':checked'));
        });
        $('#toggleAuthor').change(function() {
            var column = table.column(3);
            column.visible($(this).is(':checked'));
        });
        $('#toggleDescription').change(function() {
            var column = table.column(4);
            column.visible($(this).is(':checked'));
        });
        flatpickr('#publishedAt', {
            dateFormat: 'Y-m-d',
            allowInput: true
        });
    });
</script>
@endpush