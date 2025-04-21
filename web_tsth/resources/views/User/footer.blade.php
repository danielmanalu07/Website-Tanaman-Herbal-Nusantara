<footer class="footer-wrap style2 bg-apple-green">
    <div class="footer-top pt-100 pb-70">
        <img src="{{ asset('hort/assets/img/tub.svg') }}" alt="Image" class="section-img style2 md-none">
        <img src="{{ asset('hort/assets/img/footer-tree.svg') }}" alt="Image" class="footer-shape-1 md-none">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget-title">
                            <img src="{{ asset('images/logoweb-removebg.png') }}" alt="">
                        </h5>
                        <p class="comp-desc">Taman Sains Teknologi Herbal dan Hortikultura Pollung.
                        </p>
                        <div class="contact-item style1">
                            <div class="contact-icon">
                                <i class="las la-phone-volume"></i>
                            </div>
                            <div class="contact-info">
                                <a href="tel:8882222200">888-222-2200</a>
                            </div>
                        </div>
                        <div class="contact-item style1">
                            <div class="contact-icon">
                                <i class="lar la-envelope"></i>
                            </div>
                            <div class="contact-info">
                                <a href="mailto:support@hort.com">support@hort.com</a>
                            </div>
                        </div>
                        <div class="contact-item style1">
                            <div class="contact-icon">
                                <i class="las la-map-marker"></i>
                            </div>
                            <div class="contact-info">
                                <span>121 Second Street Mount Holly,
                                    NJ 08060</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget-title  sm-title">
                            Profil
                        </h5>
                        <ul class="footer-menu  list-style">
                            @foreach ($contents as $item_content)
                                <li><a
                                        href="{{ route('user.profile.detail', $item_content->id) }}">{{ $item_content->key }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 offset-xl-1 col-lg-3 col-md-6">
                    <div class="footer-widget ">
                        <h5 class="footer-widget-title sm-title">
                            Taman Kami
                        </h5>
                        <ul class="footer-menu list-style">
                            @php
                                $habitus = collect($habituses)->take(5);
                            @endphp
                            @foreach ($habitus as $item)
                                <li><a href="{{ route('user.ourgarden.detail', $item->id) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 offset-xl-1 col-lg-3 col-md-6">
                    <div class="footer-widget ">
                        <h5 class="footer-widget-title sm-title">
                            Jadwal Kerja
                        </h5>
                        <ul class="footer-menu list-style">
                            <li><a href="blog-left-sidebar.html">Senin (08.00 - 17.00)</a></li>
                            <li><a href="gallery.html">Selasa (08.00 - 17.00)</a></li>
                            <li><a href="projects.html">Rabu (08.00 - 17.00)</a></li>
                            <li><a href="about.html">Kamis (08.00 - 17.00)</a></li>
                            <li><a href="contact.html">Jumat (08.00 - 17.00)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-racing-green">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <ul class="social-profile style2 list-style">
                        <li><a target="_blank" href="https://facebook.com"><i class="lab la-facebook-f"></i>
                            </a></li>
                        <li><a target="_blank" href="https://twitter.com"> <i class="lab la-twitter"></i>
                            </a></li>
                        <li><a target="_blank" href="https://linkedin.com"> <i class="lab la-linkedin-in"></i> </a></li>
                        <li><a target="_blank" href="https://instagram.com"> <i class="lab la-instagram"></i>
                            </a></li>
                    </ul>
                </div>
                <div class="col-md-7 text-md-end">
                    <div class="copyright">
                        <p><span class="las la-copyright"></span> Tanaman Herbal Nusantara. All Rights Reserved By <a
                                href="https://hibootstrap.com/" target="_blank">TSTH2</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
