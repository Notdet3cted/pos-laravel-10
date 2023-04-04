@extends('layouts.app')

@section('content')
    <div class="content-page">
        <div class="container-fluid add-form-list">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">New Items</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.store') }}" data-toggle="validator" novalidate="true"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Name <span class="text-danger"> *</span></label>
                                            <input type="text" name="product_name"
                                                class="form-control @error('product_name') is-invalid @enderror"
                                                placeholder="Enter Product Name" required=""
                                                value="{{ old('product_name') }}">
                                            <div class="help-block with-errors"></div>
                                            <!-- error message untuk name -->
                                            @error('product_name')
                                                <div class="help-block with-errors text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Stock</label>
                                            <input type="number" name="product_stock"
                                                class="form-control @error('product_stock') is-invalid @enderror"
                                                placeholder="Enter Product Stock" required=""
                                                value="{{ old('product_stock') }}">
                                            <div class="help-block with-errors"></div>
                                            <!-- error message untuk stock -->
                                            @error('product_stock')
                                                <div class="help-block with-errors text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <label for="product_image">Choose Product
                                                    Image</label>
                                                <input type="file"
                                                    class="form-control image-file @error('product_image') is-invalid @enderror"
                                                    id="product_image" name="product_image" accept="image/*" required>
                                                {{-- <input type="file" name="product_image" class="custom-file-input"
                                                    id="customFile" required> --}}

                                                <div class="help-block with-errors"></div>

                                                <!-- error message untuk image -->
                                                @error('product_image')
                                                    <div class="help-block with-errors text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" id="table">
                                                <thead>

                                                    <tr>
                                                        <th>Level</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <select name="level[]" class="form-control"
                                                                    data-style="py-0" tabindex="null">
                                                                    <option value="ecer">Ecer</option>
                                                                    <option value="b1">Bakul 1</option>
                                                                    <option value="b2">Bakul 2</option>
                                                                    <option value="b3">Bakul 3</option>
                                                                    <option value="b4">Bakul 4</option>
                                                                    <option value="b5">Bakul 5</option>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select name="type[]" class="form-control"
                                                                    data-style="py-0" tabindex="null">
                                                                    <option value="pcs">Pcs</option>
                                                                    <option value="grs">Grosir</option>
                                                                    <option value="rtg">Renteng</option>
                                                                    <option value="dus">Dus</option>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" name="price[]" class="form-control"
                                                                    placeholder="Enter Product Price" required="">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p id="add" class="text-white btn btn-primary mr-2">
                                                                add new
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2 disabled">Add Product</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page end  -->
        </div>
    </div>
    <script>
        document.getElementById("add").addEventListener("click", function() {
            var table = document.getElementById("table");
            var newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>
                    <div class="form-group">
                        <select name="level[]" class="form-control"
                            data-style="py-0" tabindex="null">
                            <option value="ecer">Ecer</option>
                            <option value="b1">Bakul 1</option>
                            <option value="b2">Bakul 2</option>
                            <option value="b3">Bakul 3</option>
                            <option value="b4">Bakul 4</option>
                            <option value="b5">Bakul 5</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                 </td>
                 <td>
                    <div class="form-group">
                        <select name="type[]" class="form-control"
                            data-style="py-0" tabindex="null">
                            <option value="pcs">Pcs</option>
                            <option value="rtg">Renteng</option>
                            <option value="dus">Dus</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                 </td>
                 <td>
                     <div class="form-group">
                        <input type="number" name="price[]" class="form-control"
                            placeholder="Enter Product Price" required="">
                        <div class="help-block with-errors"></div>
                     </div>
                 </td>
                 <td>
                    <p id="remove" onClick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)" class="text-white btn btn-danger mr-2">
                        Remove
                    </p>
                 </td>`;
            table.appendChild(newRow);
        });

        // document.getElementById("remove").addEventListener("click", function(event) {
        //     var row = event.target.parentNode.parentNode;
        //     row.parentNode.removeChild(row);
        // });
    </script>
@endsection
