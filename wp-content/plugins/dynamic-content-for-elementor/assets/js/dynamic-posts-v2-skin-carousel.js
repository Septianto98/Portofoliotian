;var Widget_DCE_Dynamicposts_carousel_Handler = function ($scope, $) {

    var smsc = null;

	var elementSettings = get_Dyncontel_ElementSettings($scope);
    var id_scope = $scope.attr('data-id');
	var id_post = $scope.attr('data-post-id');

    var elementSwiper = $scope.find('.dce-posts-container.dce-skin-carousel');

    let dcePostsSwiper = null;

    var isCarouselEnabled = false;

    var centroDiapo = false;
    var cicloInfinito = false;
    var slideInitNum = 0;
    var slidesPerView = Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView']);

    var slideNum = $scope.find('.dce-post-item').length;

    centerDiapo = Boolean( elementSettings[DCE_dynposts_skinPrefix+'centeredSlides'] );
    cicloInfinito = Boolean( elementSettings[DCE_dynposts_skinPrefix+'loop'] );

    var elementorBreakpoints = elementorFrontend.config.breakpoints;
    //
    var dceSwiperOptions = {
        // Optional parameters
        direction: String(elementSettings[DCE_dynposts_skinPrefix+'direction_slider']) || 'horizontal', //vertical
        //
        initialSlide: slideInitNum,
        //
        reverseDirection: Boolean( elementSettings[DCE_dynposts_skinPrefix+'reverseDirection'] ),
        //
        speed: Number(elementSettings[DCE_dynposts_skinPrefix+'speed_slider']) || 300,
        // setWrapperSize: false, // Enabled this option and plugin will set width/height on swiper wrapper equal to total size of all slides. It should be used mostly as a compatibility fallback option for browser that don’t support flexbox layouts well
        // virtualTranslate: false, // Enabled this option and swiper will be operated as usual except it will not move, real translate values on wrapper will not be set. Useful when you may need to create custom slide transition
        autoHeight: Boolean( elementSettings[DCE_dynposts_skinPrefix+'autoHeight'] ), //false, // Set to true and slider wrapper will adopt its height to the height of the currently active slide
        //roundLengths: Boolean( elementSettings[DCE_dynposts_skinPrefix+'roundLengths'] ) || false, //false, // Set to true to round values of slides width and height to prevent blurry texts on usual resolution screens (if you have such)
        // nested : Boolean( elementSettings[DCE_dynposts_skinPrefix+'nested ), //false, // Set to true on nested Swiper for correct touch events interception. Use only on nested swipers that use same direction as the parent one
        // uniqueNavElements: true, // If enabled (by default) and navigation elements' parameters passed as a string (like ".pagination") then Swiper will look for such elements through child elements first. Applies for pagination, prev/next buttons and scrollbar elements
        //
        //effect: 'cube', "slide", "fade", "cube", "coverflow" or "flip"
        effect: elementSettings[DCE_dynposts_skinPrefix+'effects'] || 'slide',
        cubeEffect: {
        	shadow: Boolean( elementSettings[DCE_dynposts_skinPrefix+'cube_shadow'] ),
        	slideShadows: Boolean( elementSettings[DCE_dynposts_skinPrefix+'slideShadows'] ),
            shadowOffset: 20,
            shadowScale: 0.94,
        },
        coverflowEffect: {
            rotate: 50,
            stretch: Number(elementSettings[DCE_dynposts_skinPrefix+'coverflow_stretch']) || 0,
            depth: 100,
            modifier: Number(elementSettings[DCE_dynposts_skinPrefix+'coverflow_modifier']) || 1,
            slideShadows: Boolean( elementSettings[DCE_dynposts_skinPrefix+'slideShadows'] ),
        },
        flipEffect: {
            rotate: 30,
            slideShadows: Boolean( elementSettings[DCE_dynposts_skinPrefix+'slideShadows'] ),
            limitRotation: true,
        },
        fadeEffect: {
		    crossFade: Boolean( elementSettings[DCE_dynposts_skinPrefix+'crossFade'] )
		  },
        // PARALLAX (è da implementare)
        //paralax: true,

        // LAZY-LOADING (è da implementare)
        //lazy: true,
        /*lazy {
         loadPrevNext: false, //    Set to "true" to enable lazy loading for the closest slides images (for previous and next slide images)
         loadPrevNextAmount: 1, //  Amount of next/prev slides to preload lazy images in. Can't be less than slidesPerView
         loadOnTransitionStart: false, //   By default, Swiper will load lazy images after transition to this slide, so you may enable this parameter if you need it to start loading of new image in the beginning of transition
         elementClass: 'swiper-lazy', //    CSS class name of lazy element
         loadingClass: 'swiper-lazy-loading', //    CSS class name of lazy loading element
         loadedClass: 'swiper-lazy-loaded', //  CSS class name of lazy loaded element
         preloaderClass: 'swiper-lazy-preloader', //    CSS class name of lazy preloader
         },*/

        // ZOOM (è da implementare)
        /*zoom {
         maxRatio:  3, // Maximum image zoom multiplier
         minRatio: 1, //    Minimal image zoom multiplier
         toggle: true, //   Enable/disable zoom-in by slide's double tap
         containerClass:    'swiper-zoom-container', // CSS class name of zoom container
         zoomedSlideClass: 'swiper-slide-zoomed' // CSS class name of zoomed in container
         },*/
        initialSlide: Number(elementSettings[DCE_dynposts_skinPrefix+'initialSlide']) || 0,
        slidesPerView: slidesPerView || 'auto',
        slidesPerGroup: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup']) || 1, // Set numbers of slides to define and enable group sliding. Useful to use with slidesPerView > 1
        slidesPerColumn: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn']) || 1, // 1, // Number of slides per column, for multirow layout

        spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween']) || 0, // 30,
        slidesOffsetBefore: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetBefore']) || 0, //   Add (in px) additional slide offset in the beginning of the container (before all slides)
        slidesOffsetAfter: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetAfter']) || 0, //    Add (in px) additional slide offset in the end of the container (after all slides)

        slidesPerColumnFill: String(elementSettings[DCE_dynposts_skinPrefix+'slidesPerColumnFill']) || 'row', //Could be 'column' or 'row'. Defines how slides should fill rows, by column or by row

        centerInsufficientSlides: true,

        //watchOverflow: Boolean( elementSettings[DCE_dynposts_skinPrefix+'watchOverflow'] ),
        centeredSlides: centroDiapo,
        centeredSlidesBounds: Boolean( elementSettings[DCE_dynposts_skinPrefix+'centeredSlidesBounds'] ),
        //
        grabCursor: Boolean( elementSettings[DCE_dynposts_skinPrefix+'grabCursor'] ), //true,

        //------------------- Freemode
        freeMode: Boolean( elementSettings[DCE_dynposts_skinPrefix+'freeMode'] ),
        freeModeMomentum: Boolean( elementSettings[DCE_dynposts_skinPrefix+'freeModeMomentum'] ),
        freeModeMomentumRatio: Number(elementSettings[DCE_dynposts_skinPrefix+'freeModeMomentumRatio']) || 1,
        freeModeMomentumVelocityRatio: Number(elementSettings[DCE_dynposts_skinPrefix+'freeModeMomentumVelocityRatio']) || 1,
        freeModeMomentumBounce: Boolean( elementSettings[DCE_dynposts_skinPrefix+'freeModeMomentumBounce'] ),
        freeModeMomentumBounceRatio: Number(elementSettings[DCE_dynposts_skinPrefix+'speed']) || 1,
        freeModeMinimumVelocity: Number(elementSettings[DCE_dynposts_skinPrefix+'speed']) || 0.02,
        freeModeSticky: Boolean( elementSettings[DCE_dynposts_skinPrefix+'freeModeSticky'] ),

        loop: cicloInfinito, // true,
        //loopFillGroupWithBlank: true,

        // ----------------------------
        // HASH (è da implementare)
        /*hashNavigation: {
         //watchState   //default: false    Set to true to enable also navigation through slides (when hashnav is enabled) by browser history or by setting directly hash on document location
         replaceState: true,    // default: false //    Works in addition to hashnav to replace current url state with the new one instead of adding it to history
         },*/
        // HISTORY (è da implementare)
        //history: false,
        /*history: {
         replaceState: false, //    Works in addition to hashnav or history to replace current url state with the new one instead of adding it to history
         key: 'slides' //   Url key for slides
         },*/
        // CONTROLLER (è da implementare)
        //controller: false,
        /*controller: {
         control:   [Swiper Instance]   undefined   Pass here another Swiper instance or array with Swiper instances that should be controlled by this Swiper
         inverse: false, // Set to true and controlling will be in inverse direction
         by: 'slide', // Can be 'slide' or 'container'. Defines a way how to control another slider: slide by slide (with respect to other slider's grid) or depending on all slides/container (depending on total slider percentage)
         },*/


        // ----------------------------


        navigation: {
            nextEl: id_post ? '.elementor-element-' + id_scope + '[data-post-id="' + id_post + '"] .next-' + id_scope : '.next-' + id_scope, //'.swiper-button-next',
            prevEl: id_post ? '.elementor-element-' + id_scope + '[data-post-id="' + id_post + '"] .prev-' + id_scope : '.prev-' + id_scope, //'.swiper-button-prev',
            //hideOnClick: false,
            //disabledClass: 'swiper-button-disabled', //   CSS class name added to navigation button when it becomes disabled
            //hiddenClass: 'swiper-button-hidden', //   CSS class name added to navigation button when it becomes hidden
        },
        pagination: {
            el: id_post ? '.elementor-element-' + id_scope + '[data-post-id="' + id_post + '"] .pagination-' + id_scope : '.pagination-' + id_scope,
            clickable: true,
            //hideOnClick: true,
            type: String(elementSettings[DCE_dynposts_skinPrefix+'pagination_type']) || 'bullets', //"bullets", "fraction", "progressbar" or "custom"

            //bulletElement: 'span',
            dynamicBullets: Boolean( elementSettings[DCE_dynposts_skinPrefix+'dynamicBullets'] ),
            //dynamicMainBullets: 1,

            renderBullet: function (index, className) {
            	var indexLabel = !Boolean( elementSettings[DCE_dynposts_skinPrefix+'dynamicBullets']) && Boolean( elementSettings[DCE_dynposts_skinPrefix+'bullets_numbers']) ? '<span class="swiper-pagination-bullet-title">'+(index+1)+'</span>' : '';

             return '<span class="' + className + '">'+indexLabel+'</span>';
             },
            renderFraction: function (currentClass, totalClass) {
                        return '<span class="' + currentClass + '"></span>' +
                               '<span class="separator">' + String(elementSettings[DCE_dynposts_skinPrefix+'fraction_separator']) + '</span>' +
                               '<span class="' + totalClass + '"></span>';
                        },
            renderProgressbar: function (progressbarFillClass) {
             return '<span class="' + progressbarFillClass + '"></span>';
             },
            renderCustom: function (swiper, current, total) {
             /*<ul class="dce-scrollify-pagination nav--xusni">
             <li><a href="#87dc4a5" class="nav__item" aria-label="1"><span class="nav__item-title">01</span></a></li>
             <li><a href="#597993a" class="nav__item" aria-label="2"><span class="nav__item-title">02</span></a></li>
             <li><a href="#6f9669f" class="nav__item nav__item--current" aria-label="3"><span class="nav__item-title">03</span></a></li>
             <li><a href="#b8a16d0" class="nav__item" aria-label="4"><span class="nav__item-title">04</span></a></li>
             </ul>*/
             /*var custom_pagination_type = String(elementSettings[DCE_dynposts_skinPrefix+'custom_pagination_type']);
             var list = '<ul class="dce-carousel-custom-pagination nav--'+custom_pagination_type+'">';
             for(i = 1; i <= total; i++){
             	var current_item = '';
             	if(i == current) current_item = ' nav__item--current';
             	list += '<li class="nav__item'+current_item+'" aria-label="'+i+'"></li>';
             }
             list += '</ul>';
             return list;*/
             }


            // bulletClass::    'swiper-pagination-bullet', //  CSS class name of single pagination bullet
            // bulletActiveClass:   'swiper-pagination-bullet-active', //   CSS class name of currently active pagination bullet
            // modifierClass:   'swiper-pagination-', //    The beginning of the modifier CSS class name that will be added to pagination depending on parameters
            // currentClass:    'swiper-pagination-current', // CSS class name of the element with currently active index in "fraction" pagination
            // totalClass:  'swiper-pagination-total', //   CSS class name of the element with total number of "snaps" in "fraction" pagination
            // hiddenClass:     'swiper-pagination-hidden', //  CSS class name of pagination when it becomes inactive
            // progressbarFillClass:    'swiper-pagination-progressbar-fill', //    CSS class name of pagination progressbar fill element
            // clickableClass:  'swiper-pagination-clickable', //   CSS class name set to pagination when it is clickable
        },
        // watchSlidesProgress:  Boolean( elementSettings[DCE_dynposts_skinPrefix+'watchSlidesProgress ), //false, // Enable this feature to calculate each slides progress
        // watchSlidesVisibility:  Boolean( elementSettings[DCE_dynposts_skinPrefix+'watchSlidesVisibility ), // false, // WatchSlidesProgress should be enabled. Enable this option and slides that are in viewport will have additional visible classes
        scrollbar: {
         el: '.swiper-scrollbar', //    null    String with CSS selector or HTML element of the container with scrollbar.
         hide: Boolean( elementSettings[DCE_dynposts_skinPrefix+'scrollbar_hide'] ),    // boolean  true    Hide scrollbar automatically after user interaction
         draggable: Boolean( elementSettings[DCE_dynposts_skinPrefix+'scrollbar_draggable'] ), //true, // Set to true to enable make scrollbar draggable that allows you to control slider position
         snapOnRelease: true, // Set to true to snap slider position to slides when you release scrollbar
         //dragSize: 'auto', //     string/number   Size of scrollbar draggable element in px
         },
        mousewheel: Boolean( elementSettings[DCE_dynposts_skinPrefix+'mousewheelControl'] ), // true,
        /*mousewheel: {
            forceToAxis: false //   Set to true to force mousewheel swipes to axis. So in horizontal mode mousewheel will work only with horizontal mousewheel scrolling, and only with vertical scrolling in vertical mode.
            releaseOnEdges: false // Set to true and swiper will release mousewheel event and allow page scrolling when swiper is on edge positions (in the beginning or in the end)
            invert: false // Set to true to invert sliding direction
            sensitivity: 1, // Multiplier of mousewheel data, allows to tweak mouse wheel sensitivity
            eventsTarged: 'container' // String with CSS selector or HTML element of the container accepting mousewheel events. By default it is swiper-container
        },*/
        //keyboard: Boolean( elementSettings[DCE_dynposts_skinPrefix+'keyboardControl ),

         keyboard: {
            enabled: Boolean( elementSettings[DCE_dynposts_skinPrefix+'keyboardControl'] ),
            //onlyInViewport: false,
        },
        //     },

        //updateOnWindowResize: true,
        //setWrapperSize: true,

        thumbs: {
            swiper: galleryThumbs
          },

        on: {
            init: function () {
            	isCarouselEnabled = true;
              	$('body').attr('data-carousel-'+id_scope, this.realIndex);

            },
            slideChange: function (e) {
              	$('body').attr('data-carousel-'+id_scope, this.realIndex);
            },
          }
    };
    if (elementSettings[DCE_dynposts_skinPrefix+'useAutoplay']) {

        //default
        dceSwiperOptions = $.extend(dceSwiperOptions, {autoplay: true});

        //
        var autoplayDelay = Number(elementSettings[DCE_dynposts_skinPrefix+'autoplay']);
        if ( !autoplayDelay ) {
            //delay: Number(elementSettings[DCE_dynposts_skinPrefix+'autoplay) || 3000, // 2500, // Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled
            autoplayDelay = 3000;
        }else{
            autoplayDelay = Number(elementSettings[DCE_dynposts_skinPrefix+'autoplay']);
        }
        dceSwiperOptions = $.extend(dceSwiperOptions, {autoplay: {delay: autoplayDelay, disableOnInteraction: Boolean(elementSettings[DCE_dynposts_skinPrefix+'autoplayDisableOnInteraction']), stopOnLastSlide: Boolean(elementSettings[DCE_dynposts_skinPrefix+'autoplayStopOnLast']) }});

    }
    var responsivePoints = dceSwiperOptions.breakpoints = {};
    responsivePoints[elementorBreakpoints.lg] = {
        slidesPerView: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView']) || 'auto',
        slidesPerGroup: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup']) || 1,
        spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween']) || 0,
        slidesPerColumn: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn']) || 1,
        spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween']) || 0,
        slidesOffsetBefore: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetBefore']) || 0,
        slidesOffsetAfter: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetAfter']) || 0,
    };
    responsivePoints[elementorBreakpoints.md] = {
        slidesPerView: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView']) || 'auto',
        slidesPerGroup: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup']) || 1,
        spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween']) || 0,
        slidesPerColumn: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn']) || 1,
        spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween_tablet']) || 0,
        slidesOffsetBefore: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetBefore_tablet']) || 0,
        slidesOffsetAfter: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetAfter_tablet']) || 0,
    };
    responsivePoints[elementorBreakpoints.xs] = {
        slidesPerView: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView_mobile']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerView']) || 'auto',
        slidesPerGroup: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup_mobile']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesPerGroup']) || 1,
        spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween_mobile']) || Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween']) || 0,
        slidesPerColumn: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn_mobile']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn_tablet']) || Number(elementSettings[DCE_dynposts_skinPrefix+'slidesColumn']) || 1,
    	  spaceBetween: Number(elementSettings[DCE_dynposts_skinPrefix+'spaceBetween_mobile']) || 0,
        slidesOffsetBefore: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetBefore_mobile']) || 0,
        slidesOffsetAfter: Number(elementSettings[DCE_dynposts_skinPrefix+'slidesOffsetAfter_mobile']) || 0,
    };
    dceSwiperOptions = $.extend(dceSwiperOptions, responsivePoints);


    function initSwiperCarousel() {
        if(smsc) smsc.remove();

        if(dcePostsSwiper) {
          dcePostsSwiper.destroy();
        }

        if ( 'undefined' === typeof Swiper ) {
          const asyncSwiper = elementorFrontend.utils.swiper;

          new asyncSwiper( elementSwiper[0], dceSwiperOptions ).then( ( newSwiperInstance ) => {
            dcePostsSwiper = newSwiperInstance;
          } );
        } else {
          dcePostsSwiper = new Swiper( elementSwiper[0], dceSwiperOptions );
        }

	}
	if( elementSwiper.length )
	initSwiperCarousel();

	// Funzione di callback eseguita quando avvengono le mutazioni
	var Dyncontel_MutationObserverCallback = function(mutationsList, observer) {
	    for(var mutation of mutationsList) {
	        if (mutation.type == 'attributes') {
	           if (mutation.attributeName === 'class') {
		            if (isCarouselEnabled) {
				      dcePostsSwiper.update();
				    }
		        }
	        }
	    }
	};
	observe_Dyncontel_element($scope[0], Dyncontel_MutationObserverCallback);
};

jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/dce-dynamicposts-v2.carousel', Widget_DCE_Dynamicposts_carousel_Handler);
});
