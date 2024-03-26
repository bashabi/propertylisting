<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>

<?php loadPartial('top-banner'); ?>

<?php loadPartial('message'); ?>
<section class="container mx-auto p-4 mt-4">
    <div class="rounded-lg shadow-md bg-white p-3">
        <div class="flex justify-between items-center">
            <a class="block p-4 text-blue-700" href="/listings">
                <i class="fa fa-arrow-alt-circle-left"></i>
                Back To Listings
            </a>
            <div class="flex space-x-4 ml-4">
                <a href="/listings/edit/<?= $listing->id ?>" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                <!-- Delete Form -->
                <form method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
                </form>
                <!-- End Delete Form -->
            </div>
        </div>

        <div class="p-4">
            <h2 class="text-xl font-semibold"><?= $listing->title ?></h2>
            <p class="text-gray-700 text-lg mt-2">
                <?= $listing->description ?>
            </p>
            <ul class="my-4 bg-gray-100 p-4">
                <li class="mb-2"><strong>Price: </strong><?= formatPrice($listing->price) ?></li>

                <li class="mb-2">
                    <strong>Address:</strong> <?= $listing->address ?>

                </li>
                <li class="mb-2">
                    <strong>Location:</strong> <?= $listing->city ?> , <?= $listing->state ?>

                </li>
                <li class="mb-2">
                    <strong>Type:</strong> <span><?= $listing->type ?></span>
                </li>
                <li class="mb-2">
                    <strong>Contact Details:</strong> <span><?= $listing->phone ?></span> ; <span> <?= $listing->email ?> </span>
                </li>
            </ul>
        </div>
    </div>
</section>

<?php loadPartial('bottom-banner'); ?>
<?php loadPartial('footer'); ?>