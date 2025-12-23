<footer class="bg-gray-900 text-white pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ route('home', app()->getLocale()) }}" class="text-2xl font-bold text-white mb-4 block">
                    Mstore<span class="text-primary">24</span>
                </a>
                <p class="text-gray-400 text-sm mb-6">
                    {{ __('your_one_stop_shop') }}
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i
                            class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-6">{{ __('quick_links') }}</h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="{{ route('home', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('home') }}</a></li>
                    <li><a href="{{ route('shop', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('shop') }}</a></li>
                    <li><a href="{{ route('about', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('about_us') }}</a></li>
                    <li><a href="{{ route('contact', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('contact_us') }}</a></li>
                </ul>
            </div>

            <!-- Customer Care -->
            <div>
                <h3 class="text-lg font-bold mb-6">{{ __('customer_care') }}</h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="{{ route('user.profile.index', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('my_account') }}</a></li>
                </ul>
            </div>

            <!-- Policies -->
            <div>
                <h3 class="text-lg font-bold mb-6">{{ __('policies') }}</h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="{{ route('privacy', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('privacy_policy') }}</a></li>
                    <li><a href="{{ route('terms', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('terms_conditions') }}</a></li>
                    <li><a href="{{ route('shipping.policy', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('shipping_policy') }}</a></li>
                    <li><a href="{{ route('returns.policy', app()->getLocale()) }}"
                            class="hover:text-primary transition">{{ __('returns_policy') }}</a></li>
                </ul>
            </div>
        </div>

        <div
            class="border-t border-gray-800 pt-8 mt-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm">
                &copy; 2025 Mstore24. {{ __('all_rights_reserved') }}
            </p>
            <p class="text-gray-500 text-sm mt-2 md:mt-0">
                {{ __('made_by') }} <a href="https://mo123abdelrasoul.github.io/portfolio/" target="_blank"
                    class="text-primary hover:underline">Mohamed AbdElrasoul</a>
            </p>
        </div>
    </div>
</footer>
