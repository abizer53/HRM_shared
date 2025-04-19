<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Ticket Reply')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if(\Auth::user()->type=='employee'): ?>
            <?php if($ticket->created_by==\Auth::user()->id): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Ticket')): ?>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                    <a href="#" data-url="<?php echo e(URL::to('ticket/'.$ticket->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Ticket')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-pencil-alt"></i> <span><?php echo e(__('Edit')); ?></span></a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Ticket')): ?>
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(URL::to('ticket/'.$ticket->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Ticket')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-pencil-alt"></i> <span><?php echo e(__('Edit')); ?></span></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6">
            <?php $__currentLoopData = $ticketreply; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="card-header p-3">
                        <div class="d-flex justify-content-between w-100">
                            <h6 class="mb-0"><?php echo e(!empty(\Auth::user()->getUser($reply->created_by))?\Auth::user()->getUser($reply->created_by)->name:''); ?> </h6>
                            <small class="text-gray text-xs"><?php echo e($reply->created_at->diffForHumans()); ?></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><?php echo e($reply->description); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($ticket->status=='open'): ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header p-3">
                        <div class="d-flex justify-content-between w-100">
                            <h6 class="m-0"><?php echo e(__('Add Reply')); ?></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php echo e(Form::open(array('url'=>'ticket/changereply','method'=>'post'))); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

                                    <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Ticket Reply')))); ?>

                                </div>
                            </div>
                            <div class="col-12">
                                <input type="hidden" value="<?php echo e($ticket->id); ?>" name="ticket_id">
                                <input type="submit" value="<?php echo e(__('Send')); ?>" class="btn-create badge-blue">
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splashho/public_html/hrmsys/resources/views/ticket/reply.blade.php ENDPATH**/ ?>