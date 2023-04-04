<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS Dash | Responsive Bootstrap 4 Admin Dashboard Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/backend-plugin.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/backend.css?v=1.0.0')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/remixicon/fonts/remixicon.css')); ?>">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class=" color-light ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a
                                        href="<?php echo e(asset('backend/privacy-policy.html')); ?>">Privacy
                                        Policy</a></li>
                                <li class="list-inline-item"><a
                                        href="<?php echo e(asset('backend/terms-of-service.html')); ?>">Terms
                                        of
                                        Use</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <span class="mr-1">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>©
                            </span> <a href="#" class="">POS Dash</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Backend Bundle JavaScript -->
    <script src="<?php echo e(asset('assets/js/backend-bundle.min.js')); ?>"></script>

    <!-- Table Treeview JavaScript -->
    <script src="<?php echo e(asset('assets/js/table-treeview.js')); ?>"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?php echo e(asset('assets/js/customizer.js')); ?>"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="<?php echo e(asset('assets/js/chart-custom.js')); ?>"></script>

    <!-- app JavaScript -->
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

    
    <script>
        //message with toastr
        <?php if(session()->has('success')): ?>

            toastr.success('<?php echo e(session('success')); ?>', 'BERHASIL!');
        <?php elseif(session()->has('error')): ?>

            toastr.error('<?php echo e(session('error')); ?>', 'GAGAL!');
        <?php endif; ?>
    </script>
</body>

</html>
<?php /**PATH D:\project\laravel\pos-laravel-10\resources\views/layouts/app.blade.php ENDPATH**/ ?>