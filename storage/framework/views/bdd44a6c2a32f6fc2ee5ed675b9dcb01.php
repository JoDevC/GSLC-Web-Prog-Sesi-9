<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mt-0">BeeFlix</h1>

    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center ">
                <img src="<?php echo e(asset('image/beeflix.png')); ?>" alt="Beeflix Logo" class="img-fluid" style="max-width: 250px;">
                <div class="d-flex justify-content-center">
                    <a href="<?php echo e(route('movies.create')); ?>" class="btn btn-dark" style="width: 220px">Add New Movie</a>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('movies.index')); ?>" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search">
            <button class="btn btn-dark" type="submit">Search</button>
        </div>
    </form>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col">
                <div class="card h-100 shadow-sm rounded">
                    <img src="<?php echo e(asset('storage/'.$movie->photo)); ?>" alt="<?php echo e($movie->title); ?>" class="card-img-top" style="width: 100%; height: 400px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($movie->title); ?></h5>
                        <p><?php echo e($movie->genre->name); ?></p>
                        <p class="card-text"><?php echo e($movie->description); ?></p>
                        <p><?php echo e(\Carbon\Carbon::parse($movie->publish_date)->format('d-m-Y')); ?></p>

                        <form action="<?php echo e(route('movies.destroy', $movie->id)); ?>" method="POST" style="display: inline;" id="delete-form-<?php echo e($movie->id); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="btn btn-danger" style="width: 100%" onclick="confirmDelete(<?php echo e($movie->id); ?>)">Delete</button>
                        </form>
                    </div>
                </div>
            </div>  
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-4">
        <?php echo e($movies->links('pagination::bootstrap-5')); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function confirmDelete(movieId) {
        if (confirm('Are you sure you want to delete this movie?')) {
            document.getElementById('delete-form-' + movieId).submit();
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/makanbang/Documents/Semester 5/Web Programming/Web Programming - Sesi 9/GSLCWebProgSesi9/resources/views/movies/index.blade.php ENDPATH**/ ?>