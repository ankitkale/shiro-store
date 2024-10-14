@extends('Admin.Layout.layout')

@section('title', 'Shiro Store')

@section('page-heading')
    Welcome @if (Auth::check())
        {{ Auth::user()->name }}
    @else
        <p>Please log in.</p>
    @endif 🎉
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <div class="row mb-4">
    <div class="col-3">
      <a href="#" class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Total Employee</span>
          <h3 class="card-title mb-2">sfgdfsg</h3>
        </div>
      </a>
    </div>
    <div class="col-3">
      <a href="#" class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Total Contactor</span>
          <h3 class="card-title mb-2">gsdfg</h3>
        </div>
      </a>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Total Monthly Expense</span>
          <h3 class="card-title mb-2"></h3>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Today's Expense</span>
          <h3 class="card-title mb-2"></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-6">
      <div class="card">
        <canvas id="expensesChart" width="400" height="200"></canvas>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <canvas id="weekly_expensesChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div> --}}

        <div class="card-header">
            <!-- Button to trigger add modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                Add Product
            </button>
        </div>


        <!-- Table -->
        <div class="card mb-4">
            <h5 class="card-header">Products</h5>
            <div class="table-responsive text-nowrap">
                <input type="text" id="search" class="form-control mb-3" placeholder="Search products..." />

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>amount</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Date Modified</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="product-table-body">
                        <tr>
                            <td colspan="5">No Products Found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- add product -->
            <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProduct" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addJoiningPlaceModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addJoiningPlaceForm" method="POST" enctype="multipart/form-data">
                                @csrf <!-- CSRF token will be automatically included -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Product Name" aria-describedby="nameHelp">
                                        <label for="name">Product Name</label>
                                        <span class="text-danger name_err"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="amount" type="number" class="form-control" id="amount"
                                            placeholder="200.00" aria-describedby="amountHelp">
                                        <label for="amount">amount</label>
                                        <span class="text-danger amount_err"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea name="description" class="form-control" id="description" placeholder="Product Description"
                                            aria-describedby="descriptionHelp"></textarea>
                                        <label for="description">Product Description</label>
                                        <span class="text-danger description_err"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="image" type="file" class="form-control" id="image"
                                            aria-describedby="imageHelp">
                                        <label for="image">Product Image</label>
                                        <span class="text-danger image_err"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="addProductBtn" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Product Modal -->
            <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Name: </strong> <span id="viewProductName"></span></li>
                                <li class="list-group-item"><strong>Amount: </strong> <span id="viewProductAmount"></span>
                                </li>
                                <li class="list-group-item"><strong>Description: </strong> <span
                                        id="viewProductDescription"></span></li>
                                <li class="list-group-item"><strong>Image: </strong> <img id="viewProductImage"
                                        width="100" alt="Product Image"></li>
                                <li class="list-group-item"><strong>Date Modified: </strong> <span
                                        id="viewProductUpdatedAt"></span></li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editProductForm">
                                @csrf
                                <input type="hidden" id="productId" name="productId">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Product Name">
                                        <label for="name">Product Name</label>
                                        <span class="text-danger name_err"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="amount" type="number" class="form-control" id="amount"
                                            placeholder="200.00">
                                        <label for="amount">Amount</label>
                                        <span class="text-danger amount_err"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
                                        <label for="description">Description</label>
                                        <span class="text-danger description_err"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="image">Product Image</label>
                                    <input name="image" type="file" class="form-control" id="image">
                                    <span class="text-danger image_err"></span>
                                    <img id="imagePreview" src="" alt="Image Preview" width="100"
                                        style="display:none; margin-top: 10px;" />
                                </div>
                                <button type="submit" id="updateProduct" class="btn btn-primary">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="productImageLarge" src="" alt="Product Image" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- / Table -->

    </div>

    <script>
        $(document).ready(function() {
            fetchProducts();

            // Search functionality
            $('#search').on('keyup', function() {
                fetchProducts($(this).val());
            });

            // Function to fetch and display products
            function fetchProducts(search = '') {
                $.ajax({
                    url: "{{ route('products.list') }}",
                    type: "GET",
                    data: {
                        search: search
                    },
                    success: function(response) {
                        let rows = '';
                        if (response.products.length > 0) {
                            $.each(response.products, function(key, product) {
                                let shortDescription = product.description.length > 30 ?
                                    product.description.substr(0, 30) + '...' :
                                    product.description;
                                rows += `
                    <tr>
                        <td><strong>${product.name}</strong></td>
                        <td>${product.amount}</td>
                        <td><span style="max-width:200px; display:inline-block;">${shortDescription}</span></td>
                        <td>${product.image ? '<img src="storage/' + product.image + '" width="50" class="product-image" data-img="storage/' + product.image + '"/>' : 'No Image'}</td>
                        <td>${new Date(product.updated_at).toLocaleDateString('en-GB')}</td>
                        <td>
                            <a href="javascript:void(0)" class="view btn btn-success btn-sm" data-id="${product.id}">View</a>  
                            <a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-id="${product.id}">Edit</a> 
                            <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="${product.id}">Delete</a>
                        </td>
                    </tr>
                `;
                            });
                        } else {
                            rows = `<tr><td colspan="6">No Products Found.</td></tr>`;
                        }
                        $('#product-table-body').html(rows);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Add Product via AJAX
            $('#addJoiningPlaceForm').on('submit', function(e) {
                e.preventDefault();

                $('.text-danger').text('');

                var formData = new FormData(this);

                $('#addProductBtn').prop('disabled', true);

                $.ajax({
                    url: "{{ route('store.product') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success,
                                timer: 1000,
                                showConfirmButton: false
                            });
                            $('#addJoiningPlaceForm')[0].reset();
                            $('#addProduct').modal('hide');

                            fetchProducts();
                        }
                $('#addProductBtn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('.name_err').text(errors.name[0]);
                            }
                            if (errors.amount) {
                                $('.amount_err').text(errors.amount[0]);
                            }
                            if (errors.description) {
                                $('.description_err').text(errors.description[0]);
                            }
                            if (errors.image) {
                                $('.image_err').text(errors.image[0]);
                            }
                        }
                $('#addProductBtn').prop('disabled', false);
                    }
                });
            });

            // view product
            $(document).on('click', '.view', function() {
                var productId = $(this).data('id');

                $.ajax({
                    url: "/product/" + productId,
                    type: "GET",
                    success: function(response) {
                        $('#viewProductName').text(response.product.name);
                        $('#viewProductAmount').text(response.product.amount);
                        $('#viewProductDescription').text(response.product.description);

                        if (response.product.image) {
                            $('#viewProductImage').attr('src', 'storage/' + response.product
                                .image).addClass('product-image').show();
                            $(document).on('click', '#viewProductImage', function() {
                                $('#productImageLarge').attr('src',
                                    'storage/' + response.product.image
                                    );
                                $('#imageModal').modal('show');
                            });
                        } else {
                            $('#viewProductImage').hide();
                        }

                        let updatedAt = new Date(response.product.updated_at);
                        $('#viewProductUpdatedAt').text(updatedAt.toLocaleDateString('en-GB'));

                        $('#viewProductModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Click event for Edit button to open modal
            $(document).on('click', '.edit', function() {
                var productId = $(this).data('id');

                $.ajax({
                    url: "/edit-product/" + productId,
                    type: "GET",
                    success: function(response) {
                        $('#editProductForm #name').val(response.product.name);
                        $('#editProductForm #amount').val(response.product.amount);
                        $('#editProductForm #description').val(response.product.description);

                        if (response.product.image) {
                            $('#editProductForm #imagePreview').attr('src', 'storage/' +
                                response.product.image).addClass('product-image').show();
                            $(document).on('click', '#imagePreview', function() {
                                $('#imagePreview').attr('src',
                                    'storage/' + response.product.image
                                    );
                                $('#imageModal').modal('show');
                            });
                        } else {
                            $('#editProductForm #imagePreview').hide();
                        }

                        $('#editProductForm #productId').val(response.product.id);

                        $('#editProductModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Handle form submission for updating the product
            $('#editProductForm').on('submit', function(e) {
                e.preventDefault();

                var productId = $('#productId').val();
                var formData = new FormData(this);

                $('#updateProduct').prop('disabled', true);

                $.ajax({
                    url: "/edit-product/" + productId,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Product Updated Successfully',
                                text: response.success,
                                timer: 1000,
                                showConfirmButton: false
                            });

                            $('#editProductModal').modal('hide');

                            fetchProducts();
                        }
                $('#updateProduct').prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('.name_err').text(errors.name[0]);
                            }
                            if (errors.amount) {
                                $('.amount_err').text(errors.amount[0]);
                            }
                            if (errors.description) {
                                $('.description_err').text(errors.description[0]);
                            }
                            if (errors.image) {
                                $('.image_err').text(errors.image[0]);
                            }
                        }
                $('#updateProduct').prop('disabled', false);

                    }
                });
            });

            $(document).on('click', '.product-image', function() {
                var imgSrc = $(this).data('img');
                $('#productImageLarge').attr('src', imgSrc);
                $('#imageModal').modal('show');
            });

            $(document).on('click', '.delete', function() {
                var productId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/delete-product/" + productId,
                            type: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.success,
                                        'success'
                                    );
                                    fetchProducts();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the product. Please try again later.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

        });
    </script>

@endsection