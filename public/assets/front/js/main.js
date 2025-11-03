

(function ($) {
    "use strict";

    /* Select Image
    -------------------------------------------------------------------------*/
    var dropdownSelect = function () {
        // $(".tf-dropdown-select").selectpicker();
        if ($(".tf-dropdown-select").length > 0) {
            const selectIMG = $(".tf-dropdown-select");

            selectIMG.find("option").each((idx, elem) => {
                const selectOption = $(elem);
                const imgURL = selectOption.attr("data-thumbnail");
                if (imgURL) {
                    selectOption.attr("data-content", `<img src="${imgURL}" alt="Country" /> ${selectOption.text()}`);
                }
            });
            selectIMG.selectpicker();
        }
    };

    /* Button Quantity
    -------------------------------------------------------------------------*/
    var btnQuantity = function () {
        $(".minus-btn").on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest("div").find("input");
            var value = parseInt($input.val(), 10);

            if (value > 1) {
                value = value - 1;
            }
            $input.val(value);
        });

        $(".plus-btn").on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest("div").find("input");
            var value = parseInt($input.val(), 10);

            if (value > -1) {
                value = value + 1;
            }
            $input.val(value);
        });
    };

    /* Delete File 
    -------------------------------------------------------------------------*/
    var deleteFile = function (e) {
        function updateCount() {
            var count = $(".list-file-delete .file-delete").length;
            $(".prd-count").text(count);
        }

        function updateTotalPrice() {
            var total = 0;

            $(".list-file-delete .tf-mini-cart-item").each(function () {
                var priceText = $(this).find(".tf-mini-card-price").text().replace("$", "").replace(",", "").trim();
                var price = parseFloat(priceText);
                if (!isNaN(price)) {
                    total += price;
                }
            });

            var formatted = total.toLocaleString("en-US", { style: "currency", currency: "USD" });
            $(".tf-totals-total-value").text(formatted);
        }

        function updatePriceEach() {
            $(".each-prd").each(function () {
                var priceText = $(this).find(".each-price").text().replace("$", "").replace(",", "").trim();
                var price = parseFloat(priceText);
                var quantity = parseInt($(this).find(".quantity-product").val(), 10);
                if (!isNaN(price) && !isNaN(quantity)) {
                    var subtotal = price * quantity;
                    var formatted = subtotal.toLocaleString("en-US", { style: "currency", currency: "USD" });
                    $(this).find(".each-subtotal-price").text(formatted);
                }
            });
        }

        function updateTotalPriceEach() {
            var total = 0;

            $(".each-list-prd .each-prd").each(function () {
                var priceText = $(this).find(".each-subtotal-price").text().replace("$", "").replace(",", "").trim();
                var price = parseFloat(priceText);
                var quantity = parseInt($(this).find(".quantity-product").val(), 10);

                if (!isNaN(price) && !isNaN(quantity)) {
                    total += price * quantity;
                }
            });

            var formatted = total.toLocaleString("en-US", { style: "currency", currency: "USD" });
            $(".each-total-price").text(formatted);
        }

        function checkListEmpty() {
            $(".wrap-empty_text").each(function () {
                var $listEmpty = $(this);
                var $textEmpty = $listEmpty.find(".box-text_empty");
                var $otherChildren = $listEmpty.find(".list-empty").children().not(".box-text_empty");
                var $boxEmpty = $listEmpty.find(".box-empty_clear");
                if ($otherChildren.length > 0) {
                    $textEmpty.hide();
                } else {
                    $textEmpty.show();
                    $boxEmpty.hide();
                }
            });
        }

        if ($(".main-list-clear").length) {
            $(".main-list-clear").each(function () {
                var $mainList = $(this);

                $mainList.find(".clear-list-empty").on("click", function () {
                    $mainList.find(".list-empty").children().not(".box-text_empty").remove();
                    checkListEmpty();
                });
            });
        }
        function ortherDel() {
            $(".container .orther-del").remove();
        }
        $(".list-file-delete").on("input", ".quantity-product", function () {
            updateTotalPrice();
        });

        $(".list-file-delete,.each-prd").on("click", ".minus-quantity, .plus-quantity", function () {
            var $quantityInput = $(this).siblings(".quantity-product");
            var currentQuantity = parseInt($quantityInput.val(), 10);

            if ($(this).hasClass("plus-quantity")) {
                $quantityInput.val(currentQuantity + 1);
            } else if ($(this).hasClass("minus-quantity") && currentQuantity > 1) {
                $quantityInput.val(currentQuantity - 1);
            }

            updateTotalPrice();
            updatePriceEach();
            updateTotalPriceEach();
        });

        $(".remove").on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            $this.closest(".file-delete").remove();
            updateCount();
            updateTotalPrice();
            checkListEmpty();
            updateTotalPriceEach();
            ortherDel();
        });

        $(".clear-file-delete").on("click", function (e) {
            e.preventDefault();
            $(this).closest(".list-file-delete").find(".file-delete").remove();
            updateCount();
            updateTotalPrice();
            checkListEmpty();
        });
        checkListEmpty();
        updateCount();
        updateTotalPrice();
        updatePriceEach();
        updateTotalPriceEach();
    };

    /* Go Top
    -------------------------------------------------------------------------*/
    var goTop = function () {
        var $goTop = $("#goTop");
        var $borderProgress = $(".border-progress");

        $(window).on("scroll", function () {
            var scrollTop = $(window).scrollTop();
            var docHeight = $(document).height() - $(window).height();
            var scrollPercent = (scrollTop / docHeight) * 100;
            var progressAngle = (scrollPercent / 100) * 360;

            $borderProgress.css("--progress-angle", progressAngle + "deg");

            if (scrollTop > 100) {
                $goTop.addClass("show");
            } else {
                $goTop.removeClass("show");
            }
        });

        $goTop.on("click", function () {
            $("html, body").animate({ scrollTop: 0 }, 0);
        });
    };

    /* Variant Picker
    -------------------------------------------------------------------------*/
    var variantPicker = function () {
        if ($(".variant-picker-item").length) {
            $(".color-btn").on("click", function (e) {
                var value = $(this).data("scroll");
                var value2 = $(this).data("color");

                $(".value-currentColor").text(value);
                $(".value-currentColor").text(value2);

                $(this).closest(".variant-picker-values").find(".color-btn").removeClass("active");
                $(this).addClass("active");
            });
            $(".size-btn").on("click", function (e) {
                var value = $(this).data("size");
                $(".value-currentSize").text(value);

                $(this).closest(".variant-picker-values").find(".size-btn").removeClass("active");
                $(this).addClass("active");
            });
        }
    };

    /* Change Value
    -------------------------------------------------------------------------*/
    var changeValue = function () {
        if ($(".tf-dropdown-sort").length > 0) {
            $(".select-item").on("click", function (event) {
                $(this).closest(".tf-dropdown-sort").find(".text-sort-value").text($(this).find(".text-value-item").text());

                $(this).closest(".dropdown-menu").find(".select-item.active").removeClass("active");

                $(this).addClass("active");

                var color = $(this).data("value-color");
                $(this).closest(".tf-dropdown-sort").find(".btn-select").find(".current-color").css("background", color);
            });
        }
    };

    /* Sidebar Mobile
    -------------------------------------------------------------------------*/
    var sidebarMobile = function () {
        if ($(".sidebar-content-wrap").length > 0) {
            var sidebar = $(".sidebar-content-wrap").html();
            $(".sidebar-mobile-append").append(sidebar);
        }
    };

    /* Check Active 
    -------------------------------------------------------------------------*/
    var checkClick = function () {
        $(".flat-check-list").on("click", ".check-item", function () {
            $(this).closest(".flat-check-list").find(".check-item").removeClass("active");
            $(this).addClass("active");
        });
    };

    /* Stagger Wrap
    -------------------------------------------------------------------------*/
    var staggerWrap = function () {
        if ($(".stagger-wrap").length) {
            var count = $(".stagger-item").length;
            for (var i = 1, time = 0.2; i <= count; i++) {
                $(".stagger-item:nth-child(" + i + ")")
                    .css("transition-delay", time * i + "s")
                    .addClass("stagger-finished");
            }
        }
    };

    /* Modal Second
    -------------------------------------------------------------------------*/
    var clickModalSecond = function () {
        $(".show-size-guide").on("click", function () {
            $("#size-guide").modal("show");
        });
        $(".show-shopping-cart").on("click", function () {
            $("#shoppingCart").modal("show");
        });
        $(".btn-icon-action.wishlist").on("click", function () {
            $("#wishlist").modal("show");
        });

        $(".btn-add-to-cart").on("click", function () {
            $(".tf-add-cart-success").addClass("active");
        });
        $(".tf-add-cart-success .tf-add-cart-close").on("click", function () {
            $(".tf-add-cart-success").removeClass("active");
        });

        $(".btn-add-note, .btn-estimate-shipping, .btn-add-gift").on("click", function () {
            var classList = {
                "btn-add-note": ".add-note",
                "btn-estimate-shipping": ".estimate-shipping",
                "btn-add-gift": ".add-gift",
            };

            $.each(classList, function (btnClass, targetClass) {
                if ($(event.currentTarget).hasClass(btnClass)) {
                    $(targetClass).addClass("open");
                }
            });
        });

        $(".tf-mini-cart-tool-close").on("click", function () {
            $(".tf-mini-cart-tool-openable").removeClass("open");
        });
    };

    /* Header Sticky
  -------------------------------------------------------------------------*/
  const headerScrollHandler = () => {
    const $header = $(".header-fix");
    const $stickyTop = $(".sticky-top");
    if ($header.length === 0) return;

    const scrollThreshold = 200;

    $(window).on("scroll", () => {
        const st = $(window).scrollTop();
        const navbarHeight = $header.outerHeight();

        if (st < scrollThreshold) {
            // 200px से कम → हेडर normal
            $header.css("top", "unset").removeClass("header-sticky is-fixed");
            $stickyTop.css("top", "15px");
        } else {
            // 200px से ज्यादा → हेडर हमेशा दिखे
            $header.css("top", "0").addClass("header-sticky is-fixed");
            $stickyTop.css("top", `${15 + navbarHeight}px`);
        }
    });
};

$(document).ready(headerScrollHandler);


    /* Auto Popup
    -------------------------------------------------------------------------*/
    var autoPopup = function () {
        if ($(".auto-popup").length > 0) {
            let showPopup = sessionStorage.getItem("showPopup");
            if (!JSON.parse(showPopup)) {
                setTimeout(function () {
                    $(".auto-popup").modal("show");
                }, 2000);
            }
        }
        $(".btn-hide-popup").on("click", function () {
            sessionStorage.setItem("showPopup", true);
        });
    };

    /* Total Price Variant
    -------------------------------------------------------------------------*/
    var totalPriceVariant = function () {
        $(".tf-product-info-list,.tf-cart-item").each(function () {
            var productItem = $(this);
            var basePrice =
                parseFloat(productItem.find(".price-on-sale").data("base-price")) ||
                parseFloat(productItem.find(".price-on-sale").text().replace("$", "").replace(/,/g, ""));
            var quantityInput = productItem.find(".quantity-product");
            var personSale = parseFloat(productItem.find(".number-sale").data("person-sale") || 5);
            var compareAtPrice = basePrice * (1 + personSale / 100);

            productItem.find(".compare-at-price").text(`$${compareAtPrice.toLocaleString("en-US", { minimumFractionDigits: 2 })}`);
            productItem.find(".color-btn, .size-btn").on("click", function () {
                quantityInput.val(1);
            });

            productItem.find(".btn-increase").on("click", function () {
                var currentQuantity = parseInt(quantityInput.val(), 10);
                quantityInput.val(currentQuantity + 1);
                updateTotalPrice(null, productItem);
            });

            productItem.find(".btn-decrease").on("click", function () {
                var currentQuantity = parseInt(quantityInput.val(), 10);
                if (currentQuantity > 1) {
                    quantityInput.val(currentQuantity - 1);
                    updateTotalPrice(null, productItem);
                }
            });

            function updateTotalPrice(price, scope) {
                var currentPrice = price || parseFloat(scope.find(".price-on-sale").text().replace("$", "").replace(/,/g, ""));
                var quantity = parseInt(scope.find(".quantity-product").val(), 10);
                var totalPrice = currentPrice * quantity;

                scope.find(".price-add").text(`$${totalPrice.toLocaleString("en-US", { minimumFractionDigits: 2 })}`);
            }
        });
    };

    /* Scroll Grid Product
    -------------------------------------------------------------------------*/
    var scrollGridProduct = function () {
        var scrollContainer = $(".wrapper-gallery-scroll");
        var activescrollBtn = null;
        var offsetTolerance = 20;

        function isHorizontalMode() {
            return window.innerWidth <= 767;
        }

        function getTargetScroll(target, isHorizontal) {
            if (isHorizontal) {
                return target.offset().left - scrollContainer.offset().left + scrollContainer.scrollLeft();
            } else {
                return target.offset().top - scrollContainer.offset().top + scrollContainer.scrollTop();
            }
        }

        $(".btn-scroll-target").on("click", function () {
            var scroll = $(this).data("scroll");
            var target = $(".item-scroll-target[data-scroll='" + scroll + "']");

            if (target.length > 0) {
                var isHorizontal = isHorizontalMode();
                var targetScroll = getTargetScroll(target, isHorizontal);

                if (isHorizontal) {
                    scrollContainer.animate({ scrollLeft: targetScroll }, 600);
                } else {
                    $("html, body").animate({ scrollTop: targetScroll }, 100);
                }

                $(".btn-scroll-target").removeClass("active");
                $(this).addClass("active");
                activescrollBtn = $(this);
            }
        });

        $(window).on("scroll", function () {
            var isHorizontal = isHorizontalMode();
            $(".item-scroll-target").each(function () {
                var target = $(this);
                var targetScroll = getTargetScroll(target, isHorizontal);

                if (isHorizontal) {
                    if ($(window).scrollLeft() >= targetScroll - offsetTolerance && $(window).scrollLeft() <= targetScroll + target.outerWidth()) {
                        $(".btn-scroll-target").removeClass("active");
                        $(".btn-scroll-target[data-scroll='" + target.data("scroll") + "']").addClass("active");
                    }
                } else {
                    if ($(window).scrollTop() >= targetScroll - offsetTolerance && $(window).scrollTop() <= targetScroll + target.outerHeight()) {
                        $(".btn-scroll-target").removeClass("active");
                        $(".btn-scroll-target[data-scroll='" + target.data("scroll") + "']").addClass("active");
                    }
                }
            });
        });
    };

    /* Handle Progress
    -------------------------------------------------------------------------*/
    var handleProgress = function () {
        if ($(".progress-cart").length > 0) {
            var progressValue = $(".progress-cart .value").data("progress");
            setTimeout(function () {
                $(".progress-cart .value").css("width", progressValue + "%");
            }, 800);
        }

        function handleProgressBar(showEvent, hideEvent, target) {
            $(target).on(hideEvent, function () {
                $(".tf-progress-bar .value").css("width", "0%");
            });

            $(target).on(showEvent, function () {
                setTimeout(function () {
                    var progressValue = $(".tf-progress-bar .value").data("progress");
                    $(".tf-progress-bar .value").css("width", progressValue + "%");
                }, 600);
            });
        }

        if ($(".popup-shopping-cart").length > 0) {
            handleProgressBar("show.bs.offcanvas", "hide.bs.offcanvas", ".popup-shopping-cart");
        }

        if ($(".popup-shopping-cart").length > 0) {
            handleProgressBar("show.bs.modal", "hide.bs.modal", ".popup-shopping-cart");
        }
    };

    /* Handle Footer
    -------------------------------------------------------------------------*/
    var handleFooter = function () {
        var footerAccordion = function () {
            var args = { duration: 250 };
            $(".footer-heading-mobile").on("click", function () {
                var $parent = $(this).parent(".footer-col-block");
                var $content = $(this).next();

                $parent.toggleClass("open");

                if (!$parent.hasClass("open")) {
                    $content.slideUp(args);
                } else {
                    $content.slideDown(args);
                }
            });
        };

        function handleAccordion() {
            if (window.matchMedia("only screen and (max-width: 575px)").matches) {
                if (!$(".footer-heading-mobile").data("accordion-initialized")) {
                    footerAccordion();
                    $(".footer-heading-mobile").data("accordion-initialized", true);
                }
            } else {
                $(".footer-heading-mobile")
                    .off("click")
                    .removeData("accordion-initialized")
                    .each(function () {
                        $(this).parent(".footer-col-block").removeClass("open").end().next().removeAttr("style");
                    });
            }
        }

        handleAccordion();
        $(window).on("resize", handleAccordion);
    };

    /* Infinite Slide 
    -------------------------------------------------------------------------*/
    var infiniteSlide = function () {
        if ($(".infiniteSlide").length > 0) {
            $(".infiniteSlide").each(function () {
                var $this = $(this);
                var style = $this.data("style") || "left";
                var clone = $this.data("clone") || 2;
                var speed = $this.data("speed") || 50;
                $this.infiniteslide({
                    speed: speed,
                    direction: style,
                    clone: clone,
                });
            });
        }
    };

    /* Add Wishlist
    -------------------------------------------------------------------------*/
    var addWishList = function () {
        $(".btn-add-wishlist, .card-product .wishlist").on("click", function () {
            let $this = $(this);
            let icon = $this.find(".icon");
            let tooltip = $this.find(".tooltip");

            $this.toggleClass("addwishlist");

            if ($this.hasClass("addwishlist")) {
                icon.removeClass("icon-heart").addClass("icon-trash");
                tooltip.text("Remove Wishlist");
            } else {
                icon.removeClass("icon-trash").addClass("icon-heart");
                tooltip.text("Add to Wishlist");
            }
        });
        $(".btn-add-wishlist2").on("click", function () {
            let $this = $(this);
            let icon = $this.find(".icon");
            let text = $this.find(".text");

            $this.toggleClass("addwishlist");

            if ($this.hasClass("addwishlist")) {
                icon.removeClass("icon-heart").addClass("icon-trash");
                text.text("Remove List");
            } else {
                icon.removeClass("icon-trash").addClass("icon-heart");
                text.text("Add to List");
            }
        });
    };

    /* Handle Sidebar Filter 
    -------------------------------------------------------------------------*/
    var handleSidebarFilter = function () {
        $("#filterShop,.sidebar-btn").on("click", function () {
            if ($(window).width() <= 1200) {
                $(".sidebar-filter,.overlay-filter").addClass("show");
            }
        });
        $(".close-filter,.overlay-filter").on("click", function () {
            $(".sidebar-filter,.overlay-filter").removeClass("show");
        });
    };
   

    /* Parallaxie 
    -------------------------------------------------------------------------*/
    var parallaxie = function () {
        var $window = $(window);

        if ($(".parallaxie").length) {
            function initParallax() {
                if ($(".parallaxie").length && $window.width() > 991) {
                    $(".parallaxie").parallaxie({
                        speed: 0.55,
                        offset: 0,
                    });
                }
            }

            initParallax();

            $window.on("resize", function () {
                if ($window.width() > 991) {
                    initParallax();
                }
            });
        }
    };

   

    /* Handle Mobile Menu
    -------------------------------------------------------------------------*/
    var handleMobileMenu = function () {
        const $desktopMenu = $(".box-nav-menu:not(.not-append)").clone();
        $desktopMenu.find(".list-ver, .list-hor,.mn-none").remove();

        const $mobileMenu = $('<ul class="nav-ul-mb"></ul>');

        $desktopMenu.find("> li.menu-item").each(function (i, menuItem) {
            const $item = $(menuItem);
            const text = $item.find("> a.item-link").clone().children().remove().end().text().trim();
            const submenu = $item.find("> .sub-menu");
            const id = "dropdown-menu-" + i;
            if (submenu.length > 0) {
                const $li = $(`
                <li class="nav-mb-item">
                    <a href="#${id}" class="collapsed mb-menu-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="${id}">
                        <span>${text}</span>
                        <span class="icon icon-caret-down"></span>
                    </a>
                    <div id="${id}" class="collapse"></div>
                </li>
            `);

                const $subNav = $('<ul class="sub-nav-menu"></ul>');

                submenu.find(".mega-menu-item").each(function (j) {
                    const heading = $(this).find(".menu-heading").text().trim();
                    const subId = `${id}-group-${j}`;
                    const $group = $(`
                    <li>
                        <a href="#${subId}" class="collapsed sub-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="${subId}">
                            <span>${heading}</span>
                            <span class="icon icon-caret-down"></span>
                        </a>
                        <div id="${subId}" class="collapse">
                            <ul class="sub-nav-menu sub-menu-level-2"></ul>
                        </div>
                    </li>
                `);

                    $(this)
                        .find(".sub-menu_list a")
                        .each(function () {
                            const $link = $(this);
                            const linkHref = $link.attr("href") || "#";
                            const title = $link.text().trim();
                            const isActive = $link.hasClass("active");

                            if (title !== "") {
                                const activeClass = isActive ? "active" : "";
                                $group
                                    .find(".sub-menu-level-2")
                                    .append(`<li><a href="${linkHref}" class="sub-nav-link ${activeClass}">${title}</a></li>`);
                            }
                        });

                    $subNav.append($group);
                });

                if ($subNav.children().length === 0) {
                    submenu.find("a").each(function () {
                        const link = $(this).attr("href") || "#";
                        const title = $(this).text().trim();
                        if (title !== "") {
                            $subNav.append(`<li><a href="${link}" class="sub-nav-link">${title}</a></li>`);
                        }
                    });
                }
                $li.find(`#${id}`).append($subNav);
                $mobileMenu.append($li);
            } else {
                $mobileMenu.append(
                    `<li class="nav-mb-item"><a href="${$item.find("a").attr("href")}" class="mb-menu-link"><span>${text}</span></a></li>`
                );
            }
        });

        $("#wrapper-menu-navigation").empty().append($mobileMenu.html());
    };

   

    /* Tabs
    -------------------------------------------------------------------------*/
    var tabs = function () {
        $(".widget-tabs").each(function () {
            $(this)
                .find(".widget-menu-tab")
                .children(".item-title")
                .on("click", function () {
                    var liActive = $(this).index();
                    var contentActive = $(this)
                        .siblings()
                        .removeClass("active")
                        .parents(".widget-tabs")
                        .find(".widget-content-tab")
                        .children()
                        .eq(liActive);
                    contentActive.addClass("active").fadeIn("slow");
                    contentActive.siblings().removeClass("active");
                    $(this).addClass("active").parents(".widget-tabs").find(".widget-content-tab").children().eq(liActive);
                });
        });
    };

    /* Text Rotate
    -------------------------------------------------------------------------*/
    var textRotate = function () {
        if ($(".wg-curve-text").length > 0) {
            $(".text-rotate").each(function () {
                const $textRotate = $(this);
                const text = $textRotate.attr("data-text") || "";
                const chars = text.split("");
                const degree = 360 / chars.length;
                $textRotate.find(".text").each(function () {
                    const $circularText = $(this);
                    $circularText.empty();
                    chars.forEach((char, i) => {
                        const $span = $("<span></span>")
                            .text(char)
                            .css({
                                transform: `rotate(${i * degree}deg)`,
                            });
                        $circularText.append($span);
                    });
                });
            });
        }
    };

    /* Custom Dropdown
    -------------------------------------------------------------------------*/
    var customDropdown = function () {
        function updateDropdownClass() {
            const $dropdown = $(".dropdown-custom");

            if ($(window).width() <= 991) {
                $dropdown.addClass("dropup").removeClass("dropstart");
            } else {
                $dropdown.addClass("dropstart").removeClass("dropup");
            }
        }
        updateDropdownClass();
        $(window).resize(updateDropdownClass);
    };

    /* Range Size
    -------------------------------------------------------------------------*/
    var rangeSize = function () {
        $(".widget-size").each(function () {
            var $rangeInput = $(this).find(".range-input input");
            var $progress = $(this).find(".progress-size");
            var $maxPrice = $(this).find(".max-size");

            $rangeInput.on("input", function () {
                var maxValue = parseInt($rangeInput.val(), 10);
                var percentMax = (maxValue / $rangeInput.attr("max")) * 100;
                $progress.css("width", percentMax + "%");

                $maxPrice.html(maxValue);
            });
        });
    };

    /* Bottom Sticky
    --------------------------------------------------------------------------------------*/
    var scrollBottomSticky = function () {
        if ($("footer").length > 0) {
            $(window).on("scroll", function () {
                var scrollPosition = $(this).scrollTop();
                var myElement = $(".tf-sticky-btn-atc");
                var footerOffset = $("footer").offset().top;
                var windowHeight = $(window).height();

                if (scrollPosition >= 500 && scrollPosition + windowHeight < footerOffset) {
                    myElement.addClass("show");
                } else {
                    myElement.removeClass("show");
                }
            });
        }
    };


    /* Video
    ------------------------------------------------------------------------------------- */
    var videoWrap = function () {
        if ($("div").hasClass("video-wrap")) {
            $(".popup-youtube").magnificPopup({
                type: "iframe",
            });
        }
    };

   
   
    /* Preloader
    -------------------------------------------------------------------------*/
    var preloader = function () {
        $("#preload").fadeOut("slow", function () {
            var $this = $(this);
            setTimeout(function () {
                $this.remove();
            }, 300);
        });
    };
    
    // Dom Ready
    $(function () {
        // headerSticky();
        // headerFixed();
        dropdownSelect();
        btnQuantity();
        deleteFile();
      
        goTop();
        variantPicker();
        changeValue();
        sidebarMobile();
        checkClick();
        staggerWrap();
        clickModalSecond();
        autoPopup();
        totalPriceVariant();
        scrollGridProduct();
        handleProgress();
        handleFooter();
        infiniteSlide();
        addWishList();
        handleSidebarFilter();
        
        parallaxie();
       
        handleMobileMenu();
        
        tabs();
        textRotate();
        customDropdown();
        rangeSize();
        scrollBottomSticky();
   
        videoWrap();
     
        preloader();
    });
})(jQuery);
