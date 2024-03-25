<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('showcase-search'); ?>
<?php loadPartial('top-banner'); ?>



<!-- Property Listings -->
<section>
    <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Recently Added Properties</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <?php foreach ($listings as $listing) { ?>
                <!-- Job Listing 1: Software Engineer -->
                <div class="rounded-lg shadow-md bg-white">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold"><?= $listing->title ?></h2>
                        <p class="text-gray-700 text-lg mt-2">
                            <?= substr($listing->description, 0, 250) . '..' ?>
                        </p>
                        <ul class="my-4 bg-gray-100 p-4 rounded">
                            <li class="mb-2"><strong>Price: </strong><?= formatPrice($listing->price) ?></li>
                            <li class="mb-2">
                                <strong>Location:</strong> <?= $listing->city ?>, <?= $listing->state ?>

                            </li>
                            <li class="mb-2">
                                <strong>Type of Property:</strong> <span><?= $listing->type ?></span>

                            </li>
                        </ul>
                        <a href="/listing/<?= $listing->id ?>" class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            Details
                        </a>
                    </div>
                </div>
            <?php } ?>



        </div>
    </div>

    <a href="/listings" class="block text-xl text-center">
        <i class="fa fa-arrow-alt-circle-right"></i>
        Show All Property
    </a>
</section>


<?php loadPartial('bottom-banner'); ?>
<?php loadPartial('footer'); ?>