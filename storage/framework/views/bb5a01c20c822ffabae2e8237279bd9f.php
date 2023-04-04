

<?php $__env->startSection('content'); ?>
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
                            <form action="<?php echo e(route('products.store')); ?>" data-toggle="validator" novalidate="true"
                                method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Name <span class="text-danger"> *</span></label>
                                            <input type="text" name="product_name"
                                                class="form-control <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Enter Product Name" required=""
                                                value="<?php echo e(old('product_name')); ?>">
                                            <div class="help-block with-errors"></div>
                                            <!-- error message untuk name -->
                                            <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="help-block with-errors text-danger">
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Stock</label>
                                            <input type="number" name="product_stock"
                                                class="form-control <?php $__errorArgs = ['product_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Enter Product Stock" required=""
                                                value="<?php echo e(old('product_stock')); ?>">
                                            <div class="help-block with-errors"></div>
                                            <!-- error message untuk stock -->
                                            <?php $__errorArgs = ['product_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="help-block with-errors text-danger">
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <label for="product_image">Choose Product
                                                    Image</label>
                                                <input type="file"
                                                    class="form-control image-file <?php $__errorArgs = ['product_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="product_image" name="product_image" accept="image/*" required>
                                                

                                                <div class="help-block with-errors"></div>

                                                <!-- error message untuk image -->
                                                <?php $__errorArgs = ['product_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="help-block with-errors text-danger">
                                                        <?php echo e($message); ?>

                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\laravel\pos-laravel-10\resources\views/admin/product/add.blade.php ENDPATH**/ ?>