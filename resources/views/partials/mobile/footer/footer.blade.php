<footer class="bg-white">
    <div class="container">
        <div class="d-flex justify-content-between py-2">
            <div class="">
                <a href="{{ route('home') }}"> <img src="{{  asset('/frontend/img/svg/home.svg') }}" alt="Home"> </a>
            </div>
            <div class="menu">
                <input type="checkbox" class="menu-open" name="menu-open" id="menu-open" />
                <label class="menu-open-button" for="menu-open">
                    <span class="hamburger hamburger-1"></span>
                    <span class="hamburger hamburger-2"></span>
                </label>
                <a href="" class="menu-item menu-item-1">
                    <img src="{{  asset('/frontend/img/svg/marker-1.svg') }}" alt="Contact Tracing">
                </a>
                <a href="" class="menu-item menu-item-2">
                    <img src="{{  asset('/frontend/img/svg/marker-1.svg') }}" alt="Contact Tracing">
                </a>
                <a href="" class="menu-item menu-item-3">
                    <img src="{{  asset('/frontend/img/svg/ct.svg') }}" alt="Contact Tracing">
                </a>
            </div>
            <div class="">
                <a href="#"><img src="{{  asset('/frontend/img/svg/not.svg') }}" alt="Notification"></a>
            </div>
        </div>
    </div>
</footer>
