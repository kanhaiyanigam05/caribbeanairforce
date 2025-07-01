<?php $__env->startPush('title'); ?>
    <title><?php echo e($meta->meta_title); ?></title>
    <meta name="keywords" content="<?php echo e($meta->meta_keywords); ?>"/>
    <meta name="description" content="<?php echo e($meta->meta_description); ?>"/>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('main'); ?>
    <section class="mt-36 max-w-[1800px] mx-auto w-full transition">
        <form action="<?php echo e(route('events.index')); ?>" method="GET" class="my-4 px-2 filter-form">
            <div class="justify-center items-center px-6">
                <h2 class="text-2xl font-bold screen768:text-3xl my-5 text-black capitalize flex-wrap">
                    <?php if(request()->city): ?>
                        <?php $city = \App\Models\City::where('name', request()->city)->first(); ?>
                        <?php if($city): ?> <?php echo e($city->heading); ?> <?php else: ?> Caribbean Events and Parties in <?php echo e(request()->city); ?> <?php endif; ?>
                    <?php else: ?>
                        Caribbean Events and Parties
                    <?php endif; ?>
                </h2>
                <div class="flex justify-between items-center">
                    <button class="text-white text-nowrap font-medium text-sm bg-black text-white px-4 py-1 rounded-[4px]">Apply Filter</button>
                    <a class="text-primary font-medium text-nowrap text-xs" href="<?php echo e(route('events.index')); ?>">Clear Filter</a>
                </div>
            </div>
            <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg mb-10">
                <div class="flex justify-center items-center gap-3 flex-col clear-filter-wrapper">
                    <div class="w-full search-wrapper">
                        <div class="relative">
                            <input type="text" name="category" value="<?php echo e(request()->category); ?>" placeholder="Event category..."
                                   class="search-input filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm capitalize"/>
                            <ul class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-sm shadow-lg max-h-56 overflow-auto dropdown-items-wrapper hidden"
                                id="cityDropdown">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-100"><?php echo e($category->title); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="no-item hidden">
                                    <p class="px-4 py-2 cursor-pointer hover:bg-gray-100">No Results Found</p>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full search-wrapper">
                        <div class="relative">
                            <input type="text" name="title" value="<?php echo e(request()->title); ?>" placeholder="Search Event"
                                   class="search-input filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm"/>
                            <ul class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-sm shadow-lg max-h-56 overflow-auto dropdown-items-wrapper hidden"
                                id="cityDropdown">
                                <?php $__currentLoopData = $searchEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $searchEvent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-100"><?php echo e($searchEvent->title); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="no-item hidden">
                                    <p class="px-4 py-2 cursor-pointer hover:bg-gray-100">No Results Found</p>
                                </div>
                            </ul>
                        </div>

                    </div>
                    <div class="w-full search-wrapper">
                        <div class="relative">
                            <input type="text" name="city" value="<?php echo e(request()->city); ?>" placeholder="Search city..."
                                   class="search-input filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm"/>
                            <ul class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-sm shadow-lg max-h-56 overflow-auto dropdown-items-wrapper hidden"
                                id="cityDropdown">
                                <?php $__currentLoopData = $searchCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $searchCity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-100"><?php echo e($searchCity->name); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="no-item hidden">
                                    <p class="px-4 py-2 cursor-pointer hover:bg-gray-100">No Results Found</p>
                                </div>
                            </ul>
                        </div>

                    </div>
                    <div class="w-full">
                        <input type="date" value="<?php echo e(request()->date); ?>" name="date" id="date"
                               class="filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm"/>
                    </div>
                </div>
            </div>
        </form>

        <div class="flex flex-col-reverse sm:flex-row justify-start items-start gap-4 sm:relative">
            <section class="w-full">
                <div class="gap-6 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2">
                    <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if (isset($component)) { $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $attributes; } ?>
<?php $component = App\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['event' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $attributes = $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $component = $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>No events found</p>
                    <?php endif; ?>
                </div>
                <?php echo e($events->links('vendor.pagination.custom')); ?>

            </section>
            <!-- Filter Section Starts Here -->
            <section class="w-11/12 mx-auto sm:w-full sm:h-[100vh] sm:sticky sm:top-0">
                <div class="mx-auto w-11/12 sm:w-full sm:h-[100vh]" id="map"></div>
            </section>
            <!-- Filter Section Ends Here -->
        </div>
    </section>
    <div class="map_img" data-favicon-url="<?php echo e(asset('/' . $data->favicon)); ?>"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/esri-leaflet-geocoder/3.1.5/esri-leaflet-geocoder-debug.min.js"></script>
    <script>
        const GEOAPIFY_API = `<?php echo e(env('GEOAPIFY_API')); ?>`;
        const map = L.map('map').setView([0, 0], 2);

        L.tileLayer(`https://maps.geoapify.com/v1/tile/osm-carto/{z}/{x}/{y}.png?apiKey=${GEOAPIFY_API}`, {
            maxZoom: 19,
        }).addTo(map);

        const paginatedEvents = <?php echo json_encode($events); ?>;
        const events = paginatedEvents.data;

        async function getCoordinates(address) {
            const url = `https://api.geoapify.com/v1/geocode/search?text=${encodeURIComponent(address)}&apiKey=${GEOAPIFY_API}`;
            const response = await fetch(url);
            const data = await response.json();
            if (data && data.features.length > 0) {
                return data.features[0].geometry.coordinates;
            }
            return null;
        }

        const faviconUrl = document.querySelector('.map_img').getAttribute('data-favicon-url');

        const customIcon = L.divIcon({
            html: `
        <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="imagePattern" patternUnits="userSpaceOnUse" width="32" height="32">
                    <image href="${faviconUrl}" x="0" y="0" width="32" height="32" />
                </pattern>
            </defs>
            <path d="M16 0C9.373 0 4 5.373 4 12c0 9.373 12 20 12 20s12-10.627 12-20c0-6.627-5.373-12-12-12z" fill="url(#imagePattern)"/>
            <circle cx="16" cy="12" r="5" fill="white" fill-opacity="0" stroke="white" stroke-width="5"/>
        </svg>
    `,
            iconSize: [32, 32],
            className: 'custom-marker'
        });


        let bounds = [];
        events.forEach(async event => {
            const coords = await getCoordinates(event.address);
            if (coords) {
                const marker = L.marker([coords[1], coords[0]], {icon: customIcon}).addTo(map);
                marker.bindPopup(`<b>${event.name}</b><br>${event.address}`);
                bounds.push([coords[1], coords[0]]);
            }
            if (bounds.length === events.length) {
                map.fitBounds(bounds);
            }
        });
    </script>

    <?php if($errors->hasBag('payment')): ?>
        <script>
            showCheckoutModel();
        </script>
    <?php endif; ?>
    
    <script>
        /*$(document).ready(function () {
            $('.filter-form').on('submit', function (e) {
                $(this).find('input, select').each(function () {
                    if ($(this).data('original-name')) {
                        $(this).attr('name', $(this).data('original-name'));
                    }

                    if (!$(this).data('original-name')) {
                        $(this).data('original-name', $(this).attr('name'));
                    }

                    if (!$(this).val()) {
                        $(this).removeAttr('name');
                    }
                });
            });
        });*/
        $(document).ready(function () {
            $('.filter-form').on('submit', function (e) {
                // Customization for city to route parameter
                const cityInput = $(this).find('input[name="city"]');
                const cityValue = cityInput.val().trim();

                if (cityValue) {
                    // Update the form's action dynamically with the city as a route parameter
                    const baseUrl = '<?php echo e(url('/')); ?>'; // Laravel base URL
                    $(this).attr('action', `${baseUrl}/${encodeURIComponent(cityValue)}`);
                    cityInput.removeAttr('name');
                }

                // Existing functionality to handle names and empty fields
                $(this).find('input, select').each(function () {
                    if ($(this).data('original-name')) {
                        $(this).attr('name', $(this).data('original-name'));
                    }

                    if (!$(this).data('original-name')) {
                        $(this).data('original-name', $(this).attr('name'));
                    }

                    if (!$(this).val()) {
                        $(this).removeAttr('name');
                    }
                });
            });
        });


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/events.blade.php ENDPATH**/ ?>