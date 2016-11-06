
// product slider

;(function($, window, document, undefined){

    "use strict";

    var Freaky = {
        init: function(options, elements){
            var basik = this;
            basik.$elem = $(elements);
            basik.options = $.extend({},
                $.fn.freakyScripts.options,
                basik.$elem.data(),
                options);

            basik.core();
        },

        core: function(){
            var basik = this;

            //carousel heights
            basik.heights = [];

            //carousel elements
            basik.preview = $('.thumbs');
            basik.previewSLide = basik.preview.find("img");
            basik.previewLength =  basik.previewSLide.length;
            basik.overflowThumbs = $('.overflow__thumbs');
            basik.carousel =  $('.freaky-scripts__carousel');
            basik.carouselArr = $('.carousel-arr');

            //head slide elements
            basik.head = $('.freaky-scripts__head');
            basik.headInner = $('.freaky-scripts__inner-head');
            basik.headSlide = basik.head.find("img");

            basik.fixHeight = basik.options.countPreview;

            // array for onload image
            basik.emptyArr = new Array();
            basik.arrFullscreen = new Array();

            //global counter
            basik.data = 0;

            //head slider
            basik.nextSlide = $('.next-slider');
            basik.prevSlide = $('.prev-slider');

            basik.body = $('body');

            //fullscreen elements
            basik.bcgFullscreen = $('.freaky-fulscreen');
            basik.closeFullscreen = $('.fullscreen-close');
            basik.innerFullscreen = $('.inner-fullscreen');
            basik.getWidthFullscreen = $('.fulscreen-all-width');
            basik.preloadFullscreen = $('.freaky-scripts__preload');
            basik.arrowLeft = $('.fullscreen-left');
            basik.arrowRight = $('.fullscreen-right');

            //zoomer elements
            basik.zoomer = $('.freaky-scripts__zoomer');
            basik.innerZoomer = $('.freaky-scripts__inner--zoom');
            basik.lens = $('.freaky-lens');

            basik.loadImage();
        },

        loadImage: function(){
            var basik = this,
                max = basik.options.previewArr.length;


            if(max > 0 && basik.options.previewArr[0] != undefined){
                for(var i=0; i < max; i++){
                    loadingImg(i);
                }

                basik.initImage();
            }

            function loadingImg(index){
                var img = new Image();

                if(max > 0 && basik.options.previewArr[index] != undefined ){

                    img.src = basik.options.previewArr[index];

                    var previewList  =  $('<li/>',{
                    }).appendTo(basik.preview);

                    $(img).appendTo(previewList);

                    img.onload = function(){

                        basik.emptyArr.push($(img));

                        if(basik.emptyArr.length == max){
                            basik.$elem
                                .find('.freaky-scripts__preload')
                                .remove();
                            basik.initPosition()
                        }
                    };
                }
            }
        },

        initImage: function(){
            var basik = this;
            basik.previewLi = basik.preview.find("li");
            basik.previewBottomSize = basik.previewLi
                .css('margin-bottom')
                .replace('px','');

            basik.previewLi.each(function(i){
                $(this).attr('data-slide','slide'+i);
            });

            basik.headSlide.each(function(i){
                $(this).attr('data-slide','slide'+i);
            });
        },

        initPosition: function(){
            var basik = this;
            var heights = [];

            basik.previewLi.find('img').each(function(){
                heights.push($(this).height());
            });

            heights.length = basik.options.countPreview;

            var getAllHeight = heights.reduce(function(a, b){
                return a + b;
            });

            basik.overflowThumbs.css({
                'height': getAllHeight + (basik.options.countPreview * (+basik.previewBottomSize))
            });

            basik.carousel.css({
                'height': 35 + getAllHeight + (basik.options.countPreview * (+basik.previewBottomSize))
            });

            basik.carouselHeight = basik.overflowThumbs.height();

            if(basik.options.previewArr.length > basik.options.countPreview){
                basik.carouselArr.addClass('carousel-arr--visible');
            }

            basik.initCarousel();

            if(basik.options.arrow === true){
                basik.initSlider();
            } else {
                basik.nextSlide.addClass('arrows-hidden');
                basik.prevSlide.addClass('arrows-hidden');
            }

            basik.initfullscreen();
            basik.initTab();
            basik.initSize();
            basik.initLens();

            if(basik.options.zoomer === true){
                basik.initZoomer();
            }
        },

        initTab : function(){
            var basik = this,
                dataSlide;

                basik.zoomerHeights = [],
                basik.zoomerWidth = [];

            basik.headSlide.each(function(){
                basik.zoomerHeights.push($(this).height());
                basik.zoomerWidth.push($(this).width());
            });

            basik.previewLi.first().addClass('active-prev');
            $(basik.previewLi).on('click', function(){
                dataSlide = $(this).data('slide');
                basik.previewLi.removeClass('active-prev');
                $(this).addClass('active-prev');
                basik.headSlide.hide(0);
                basik.head
                    .find('img[data-slide=' + dataSlide + ']')
                    .show(0);

                basik.data = $(this).index();

                basik.initSize();
                basik.initLens();
            });

        },

        initCarousel: function(){
            var basik = this;
            var carouselHeights = [];
            var counter = basik.options.countPreview;
            var getLength = basik.options.previewArr.length;

            $(basik.previewLi).each(function(indx, element){
                carouselHeights.push($(this).height());
            });

            var counterHeight = carouselHeights[counter];

            basik.carouselArr.on('click', function(){
                counter++;

                if(getLength > basik.options.countPreview && counter <= getLength){
                    startCarousel();
                } else if(counter > basik.options.countPreview){
                    restartCarousel();
                    counter = basik.options.countPreview;
                }

                counterHeight = carouselHeights[counter];
            });

            function startCarousel(){
                $(basik.preview).animate({
                    'top' : '-='+(counterHeight + (+basik.previewBottomSize))
                },150);
            }

            function restartCarousel(){
                $(basik.preview).animate({
                    'top' : 0
                });
            }
        },

        initSize: function(){
            var basik = this;
            basik.diffy = (basik.carouselHeight - basik.zoomerHeights[basik.data]) / 2;

            function addHeadSlideSize (w, h, mt){
                basik.head.css({
                    'width' : w,
                    'height' : h,
                    'marginTop' :  mt
                });
            }

            function addZoomerSlideSize (w, h, mt){
                basik.zoomer.css({
                    'width' : w,
                    'height' : h,
                    'marginTop' :  mt
                });
            }

            addHeadSlideSize (basik.zoomerWidth[basik.data], basik.zoomerHeights[basik.data], 0);
            addZoomerSlideSize (basik.zoomerWidth[basik.data], basik.zoomerHeights[basik.data], 0);

            if(basik.carouselHeight > basik.zoomerHeights[basik.data]){
                addHeadSlideSize (basik.zoomerWidth[basik.data], basik.zoomerHeights[basik.data], basik.diffy);
                addZoomerSlideSize (basik.zoomerWidth[basik.data], basik.zoomerHeights[basik.data], basik.diffy);
            } else if(basik.carouselHeight <= basik.zoomerHeights[basik.data]){
                addHeadSlideSize (basik.zoomerWidth[basik.data], basik.zoomerHeights[basik.data], 0);
                addZoomerSlideSize (basik.zoomerWidth[basik.data], basik.zoomerHeights[basik.data], 0);
            }
        },

        initLens: function(){
            var basik = this;

            basik.lw =  basik.zoomerWidth[basik.data] / 2;
            basik.lh = basik.zoomerHeights[basik.data] / 3;

            basik.lens.css({
                'width' : basik.lw,
                'height' : basik.lh
            })
        },

        initSlider: function(){
            var basik = this;
            var maxCounter = basik.headSlide.length-1;

            $('.next-slider').on('click', nextSlide);
            $('.prev-slider').on('click', prevSlide);

            function nextSlide(){
                if(basik.data < maxCounter){
                    basik.data = ++basik.data;
                    basik.headSlide.hide(0);
                    basik.head
                        .find('img[data-slide = slide' +basik.data+ ']')
                        .show(0);

                    basik.initSize();

                } else if(basik.data == maxCounter){
                    basik.data = 0;
                    basik.headSlide.hide(0);
                    basik.head
                        .find('img[data-slide = slide' +basik.data+ ']')
                        .show(0);

                    basik.initSize();
                }
            }

            function prevSlide(){
                if(basik.data <= maxCounter){
                    basik.data = --basik.data;
                    basik.headSlide.hide(0);
                    basik.head
                        .find('img[data-slide = slide' +basik.data+ ']')
                        .show(0);

                    basik.initSize();
                }
                if(basik.data < 0){
                    basik.data = maxCounter;
                    basik.headSlide.hide(0);
                    basik.head
                        .find('img[data-slide = slide' +basik.data+ ']')
                        .show(0);

                    basik.initSize();
                }
            }
        },

        initZoomer: function(){
            var basik = this;

            basik.data = 0;
            basik.zoomdata = basik.data;

            basik.head.mousemove(function(event){
                basik.zoomer.addClass('freaky-scripts__zoomer--active');

                basik.headSlide.mousemove(function(){
                    basik.zoomdata = $(this).index();
                });

                basik.lens.show();

                var mouseX = event.pageX - $(this).offset().left;
                var mouseY = event.pageY - $(this).offset().top;

                var procentX = (basik.zoomerWidth[basik.data]/4)*3;
                var procentY = (basik.zoomerHeights[basik.data]/6)*5;

                // coords x

                if(mouseX > procentX){
                    basik.lens.css({
                        'right' : 0,
                        'left': 'auto'
                    });

                } else{
                    basik.lens.css({
                        'left' : 0,
                        'right' : 'auto'
                    });
                }

                if(mouseX >= basik.lw/2 && mouseX <= procentX){
                    basik.lens.css({
                        'left' : mouseX - basik.lw/2
                    });
                }

                // coords y

                if(mouseY > procentY){
                    basik.lens.css({
                        'bottom' : 0,
                        'top': 'auto'
                    });
                } else{
                    basik.lens.css({
                        'top' : 0,
                        'bottom' : 'auto'
                    });
                }

                if(mouseY >= basik.lh/2 && mouseY <= procentY){
                    basik.lens.css({
                        'top' : mouseY - basik.lh/2
                    });
                }

                var img = new Image();
                img.src = basik.options.zoomerArr[basik.zoomdata];

                basik.innerZoomer.css({
                    'background-image' : 'url(' + img.src + ')',
                    "background-repeat"   : "no-repeat",
                    "background-position" : -mouseX+'px ' +(-mouseY) + 'px',
                    'width' : basik.zoomerWidth[basik.data] * 2,
                    'height' : basik.zoomerHeights[basik.data] * 2,
                    'background-size' : 'cover'
                });

                img.onload = function(){
                    $('.freaky-scripts__preload--zoom').remove();
                };

            });

            basik.head.mouseleave(function(){
                basik.zoomer.removeClass('freaky-scripts__zoomer--active');
                basik.lens.hide();
            });
        },

        initfullscreen: function(){
            var basik = this;
            basik.indicator = true;

            basik.headInner.on('click', function(){
                basik.bcgFullscreen.addClass('fullscreen-active');
                basik.headSlide.attr('data-slide');

                $('body').addClass('fullscreen-hidden');

                if(basik.options.headArr.length > 0 && basik.options.headArr[0] != undefined && basik.indicator){
                    for(var i=0; i < basik.options.headArr.length; i++){
                        loadingFullscreen(i);
                    }
                }

            });

            function loadingFullscreen (index){
                var img = new Image();

                if(basik.options.headArr.length>0 && basik.options.headArr[index] != undefined ){

                    img.src = basik.options.headArr[index];

                    var fullscreenList  =  $('<li/>',{
                    }).appendTo(basik.innerFullscreen);

                    $(img).appendTo(fullscreenList);

                    img.onload = function(){

                        basik.arrFullscreen.push($(img));

                        if(basik.arrFullscreen.length == basik.options.headArr.length){
                            basik.indicator = false;
                            basik.initFullscreenSlider();
                            basik.bcgFullscreen
                                .find('.freaky-scripts__preload')
                                .remove();

                        }
                    };
                }
            }

            basik.lens.on('click', function(){
                basik.data = $(this)
                    .parent('div')
                    .find('img[data-slide = slide' +basik.data+ ']')
                    .index();

                if(!basik.indicator){
                    $('.full-slide'+basik.data).show();
                }

            });
        },

        initFullscreenSlider: function(){
            var basik = this,
                widths = [],
                heights = [];

            var gw = $(window).innerWidth();
            var gh = $(window).innerHeight();

            basik.fullscreenLi = basik.innerFullscreen.find('li');
            basik.fullscreenImg = basik.fullscreenLi.find('img');

            basik.closeFullscreenHeight = basik.closeFullscreen.height();
            basik.closeFullscreenOffset = +(basik.closeFullscreen
                .css('margin-top')
                .replace('px', ''));

            basik.fullscreenItem = basik.innerFullscreen.find('li');

            var maxCounter =  basik.fullscreenItem.length - 1;

            basik.fullscreenImg.each(function(){
                widths.push($(this).width());
                heights.push($(this).height());
            });

            var dw = gw/2;
            var dh = gh/2;

            basik.fullscreenItem.each(function(i){
                $(this).attr('class', 'full-slide'+i);
            });

            basik.fullscreenItem.hide();
            basik.slideInd = $('.full-slide'+ basik.data);
            basik.slideInd.show();
            basik.diffiImageWidth = basik.slideInd.width();
            basik.diffiImageHeight = basik.slideInd.height();

            if(basik.diffiImageHeight > gh){

                basik.fullscreenLi.css({
                    'width' : 'auto',
                    'height' : gh
                });

                basik.fullscreenImg.css({
                    'width' : 'auto',
                    'height' : gh
                });

                basik.diffiImageWidth = basik.slideInd.find('img').width();

                basik.innerFullscreen.css({
                    'marginLeft': dw - basik.diffiImageWidth / 2,
                    'margin-top': 0,
                    'width' : 'auto',
                    'height' : gh
                });

            } else if (basik.diffiImageHeight < gh){
                basik.innerFullscreen.css({
                    'marginLeft': dw - basik.diffiImageWidth / 2,
                    'margin-top': dh - basik.diffiImageHeight / 2
                });
            }

            $(window).resize(function(){
                var gw = $(window).innerWidth();
                var gh = $(window).innerHeight();
                var dw = gw/2;
                var dh = gh/2;

                if(basik.diffiImageHeight > gh){

                    basik.fullscreenLi.css({
                        'width' : 'auto',
                        'height' : gh
                    });

                    basik.fullscreenImg.css({
                        'width' : 'auto',
                        'height' : gh
                    });

                    basik.diffiImageWidth = basik.slideInd.find('img').width();

                    basik.innerFullscreen.css({
                        'marginLeft': dw - basik.diffiImageWidth / 2,
                        'margin-top': 0,
                        'width' : 'auto',
                        'height' : gh
                    });

                } else if (basik.diffiImageHeight < gh){
                    basik.innerFullscreen.css({
                        'marginLeft': dw - basik.diffiImageWidth / 2,
                        'margin-top': dh - basik.diffiImageHeight / 2
                    });
                }

            });

            basik.arrowLeft.on('click', prevSlide);
            basik.arrowRight.on('click', nextSlide);

            function nextSlide(){
                if(basik.data < maxCounter){

                    basik.data = basik.data + 1;
                    basik.fullscreenItem.hide(0);

                    basik.slideInd = $('.full-slide'+ basik.data);

                    basik.diffiImageWidth = basik.slideInd.width();
                    basik.diffiImageHeight = basik.slideInd.height();

                    basik.innerFullscreen.css({
                        'marginLeft': dw - basik.diffiImageWidth / 2,
                        'margin-top': dh - basik.diffiImageHeight / 2
                    });

                    basik.slideInd.show(0);

                } else if( basik.data == maxCounter){

                    basik.data = 0;
                    basik.fullscreenItem.hide(0);
                    basik.slideInd = $('.full-slide'+ basik.data);

                    basik.diffiImageWidth = basik.slideInd.width();
                    basik.diffiImageHeight = basik.slideInd.height();

                    basik.innerFullscreen.css({
                        'marginLeft': dw - basik.diffiImageWidth / 2,
                        'margin-top': dh - basik.diffiImageHeight / 2
                    });

                    if(basik.diffiImageHeight > gh){

                        basik.innerFullscreen.css({
                            'marginLeft': dw - basik.diffiImageWidth / 2
                        });

                    } else if (basik.diffiImageHeight < gh){

                        basik.innerFullscreen.css({
                            'marginLeft': dw - basik.diffiImageWidth/2
                        });

                    }

                    basik.slideInd.show(0);
                }
            }

            function prevSlide(){
                if(basik.data <= maxCounter){

                    basik.data = basik.data - 1;
                    basik.fullscreenItem.hide(0);
                    basik.slideInd = $('.full-slide'+ basik.data);

                    basik.diffiImageWidth = basik.slideInd.width();
                    basik.diffiImageHeight = basik.slideInd.height();

                    if(basik.diffiImageHeight > gh){

                        basik.innerFullscreen.css({
                            'marginLeft': dw - basik.diffiImageWidth / 2
                        });

                    } else if (basik.diffiImageHeight < gh){

                        basik.innerFullscreen.css({
                            'marginLeft': dw - basik.diffiImageWidth/2
                        });

                    }

                    basik.slideInd.show(0);

                }
                if( basik.data < 0){

                    basik.data = maxCounter;
                    basik.fullscreenItem.hide(0);
                    basik.slideInd = $('.full-slide'+ basik.data);

                    basik.diffiImageWidth = basik.slideInd.width();
                    basik.diffiImageHeight = basik.slideInd.height();

                    if(basik.diffiImageHeight > gh){

                        basik.innerFullscreen.css({
                            'marginLeft': dw - basik.diffiImageWidth / 2
                        });

                    } else if (basik.diffiImageHeight < gh){

                        basik.innerFullscreen.css({
                            'marginLeft': dw - basik.diffiImageWidth/2
                        });

                    }

                    basik.slideInd.show(0);
                }
            }

            basik.closeFullscreen.on('click', function(){
                $('body').removeClass('fullscreen-hidden');
                basik.bcgFullscreen.removeClass('fullscreen-active');
                basik.fullscreenItem.hide();
            });
        }
    };

    $.fn.freakyScripts = function (options) {
        return this.each(function () {
            var freaky = Object.create(Freaky);
            freaky.init(options, this);
            $.data(this, "freakyScripts", freaky);
        });

    };

    $.fn.freakyScripts.options = {
        countPreview: 2,
        offsetPreview: 8,
        previewArr: [],
        headArr: [],
        zoomerArr: [],
        animationTime: 150,
        arrow: false,
        zoomer: true
    };

})(jQuery, window, document);