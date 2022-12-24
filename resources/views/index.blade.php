<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Newsletter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(request()->has('view_deleted'))
                    <a href="{{ route('newsletter.index') }}" class="btn btn-info">View All Users</a>
                    @else

                    @auth
                    <a href="{{ route('newsletter.index', ['view_deleted' => 'DeletedRecords']) }}" class="btn btn-info">View Delete Records</a>
                    @endauth

                    @endif



                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Date Published</th>
                                <th scope="col">Writer</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsletters as $newsletter)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $newsletter->title }}</td>
                                <td>{{ $newsletter->created_at }}</td>
                                <td>{{ $newsletter->user->name }}</td>
                                <td>

                                    @guest
                                    <a href="{{ route('newsletter.show' , $newsletter->id) }}" class="btn btn-primary">View</a>
                                    @endguest

                                    <!-- Button trigger modal -->

                                    @if(request()->has('view_deleted'))

                                    <a href="{{ route('newsletter.restore', $newsletter->id) }}" class="btn btn-success">Restore</a>

                                    @else

                                    @auth

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="modalBtn">
                                        Delete
                                    </button>

                                    <a href="{{ route('newsletter.edit',$newsletter->id) }}"> <button class="btn btn-success">Edit</button></a>
                                    <a href="{{ route('newsletter.show' , $newsletter->id) }}" class="btn btn-primary">View</a>

                                    @endif

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Newsletter</h5>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure want to delete?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeBtn">Close</button>

                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <form action="{{ route('newsletter.delete', $newsletter->id) }}" , method="post">
                                                            @csrf @method('delete')
                                                            <button class="btn btn-danger ">Yes</button>
                                                        </form>

                                                    </div>

                                                    @endauth

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#modalBtn").on('click', function() {
            $('#deleteModal').modal('show');
        });

        $("#closeBtn").on('click', function() {
            $('#deleteModal').modal('hide');
            $('.close').modal('hide');
        });

    </script>


</x-app-layout>
