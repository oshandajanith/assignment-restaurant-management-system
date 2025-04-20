
@extends('layouts.layouts.dashboard_layout')
@section('body-area')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<title>AddConcession</title>
<div class="content container-fluid">
				
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Concessions</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Concessions</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_expense"><i class="fa fa-plus"></i> Add Concession</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table id="concessionsTable" class="table table-striped custom-table mb-0">

                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($concessions as $concession)
                                    <tr>
                                        <td>
                                            <strong>CI/{{$concession->id}}</strong>
                                        </td>
                                        <td>{{ $concession->name }}</td>
                                        <td> <img src="{{ asset($concession->image) }}" alt="Image" width="60"></td>
                                        <td>
                                        Rs. {{ number_format($concession->price, 2) }}
                                        </td>
                                        <td>{{ $concession->description }}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ route('concession.view', $concession->id) }}" data-toggle="modal" data-target="#view_concession_{{ $concession->id }}">
                                                        <i class="fa fa-eye m-r-5"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_concession_{{ $concession->id }}">
                                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_concession_{{ $concession->id }}">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </a>

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
            <!-- /Page Content -->
            
           
           <!-- Add Concession Modal -->
<div id="add_expense" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Concessions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('concession.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item Name</label>
                                <input class="form-control" type="text" name="name" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="4" class="form-control summernote" name="description" placeholder="Enter your message here"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input class="form-control" type="text" name="price" placeholder="Rs:500" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label>
                                <input class="form-control" type="file" name="image" id="imageInput" accept="image/*" required>
                            </div>
                        </div>
                    </div>

                    <div class="attach-files">
                        <ul id="imagePreviewList"></ul>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


            <!-- /Add concession Modal -->
            
          <!-- Edit Concession Modal -->
          @foreach($concessions as $concession)
    <div id="edit_concession_{{ $concession->id }}" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Concession</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('concession.update', $concession->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Id</label>
                                    <input class="form-control" name="item_id" value="{{ old('item_id', $concession->id) }}" type="text" readonly>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" name="name" value="{{ old('name', $concession->name) }}" type="text">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" name="price" value="{{ old('price', $concession->price) }}" type="number" step="0.01">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control summernote" name="description">{{ old('description', $concession->description) }}</textarea>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
    <label>Current Image</label><br>
    <img id="preview-old" src="{{ asset($concession->image) }}" alt="Old Image" style="max-width: 200px; display: block; margin-bottom: 10px;">
    
    <label for="new-image">Change Image</label>
    <input id="new-image" class="form-control" type="file" name="image" accept="image/*">
</div>



                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

<!-- View Concession Modal -->
    @foreach($concessions as $concession)        
    <div id="view_concession_{{ $concession->id }}" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Concession</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Id</label>
                                    <input class="form-control" value="{{ $concession->id }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" value="{{ $concession->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <img src="{{ asset($concession->image) }}" width="60" class="d-block mx-auto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" value="Rs. {{ number_format($concession->price, 2) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control summernote" readonly>{{ $concession->description }}</textarea>
                        </div>
                        <div class="submit-section">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Exit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

            <!-- /view Concession Modal -->

            
           <!-- Delete Concession Modal -->
@foreach($concessions as $concession)
<div class="modal custom-modal fade" id="delete_concession_{{ $concession->id }}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Concession</h3>
                    <p>Are you sure you want to delete this concession?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <form action="{{ route('concessions.destroy', $concession->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary continue-btn w-100">Delete</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

            {{-- JavaScript for Image Preview --}}
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreviewList = document.getElementById('imagePreviewList');

    imageInput.addEventListener('change', function () {
        imagePreviewList.innerHTML = '';
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const li = document.createElement('li');
                li.innerHTML = `
                    <img src="${e.target.result}" alt="Selected Image" style="width: 100px; height: auto;" />
                    <a href="#" class="fa fa-close file-remove" onclick="removePreview(event)"></a>
                `;
                imagePreviewList.appendChild(li);
            };
            reader.readAsDataURL(file);
        }
    });

    function removePreview(event) {
        event.preventDefault();
        document.getElementById('imageInput').value = "";
        imagePreviewList.innerHTML = "";
    }
</script>

<script>
    // Optional: Preview selected new image
    document.getElementById('new-image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('preview-old').src = URL.createObjectURL(file);
        }
    });
</script>

<script>
    $(function () {
        $('#concessionsTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            ordering: true,
            columnDefs: [
                { orderable: false, targets: [2, 5] }
            ],
            language: {
                paginate: {
                    next: 'Next →',
                    previous: '← Prev'
                },
                lengthMenu: 'Show _MENU_ entries per page',
                search: 'Search:',
            }
        });
    });
</script>


          
@endsection