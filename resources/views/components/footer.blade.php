<footer class="bg-primary text-[#F5F7F6] px-10 py-16 flex flex-col">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

        <div class="flex flex-col gap-2 items-start">
            <img id="logo-footer" src="/images/progrest_logo_white.png" alt="" class="w-40 h-auto">
            <p class="font-montserrat text-sm opacity-80 text-text-contrast">
                {{ __('main.footer.tagline') }}
            </p>
        </div>

        <div>
            <h2 class="font-parkinsans font-semibold mb-3 text-text-contrast">{{ __('main.footer.product') }}</h2>
            <ul class="font-montserrat space-y-3 text-sm opacity-80 text-text-contrast">
                <li><a href="/dashboard" class="hover:opacity-100">{{ __('main.footer.dashboard') }}</a></li>
                <li><a href="/projects" class="hover:opacity-100">{{ __('main.footer.projects') }}</a></li>
                <li><a href="/collab" class="hover:opacity-100">{{ __('main.footer.collaboration') }}</a></li>
            </ul>
        </div>

        <div>
            <h2 class="font-parkinsans font-semibold mb-3 text-text-contrast">{{ __('main.footer.social-media') }}</h2>
            <ul class="font-montserrat space-y-3 text-sm opacity-80 text-text-contrast">
                <li><a href="#" class="hover:opacity-100">Twitter</a></li>
                <li><a href="#" class="hover:opacity-100">Facebook</a></li>
                <li><a href="#" class="hover:opacity-100">Instagram</a></li>
            </ul>
        </div>

        <div>
            <h2 class="font-parkinsans font-semibold mb-3 text-text-contrast">{{ __('main.footer.resources') }}</h2>
            <ul class="font-montserrat space-y-3 text-sm opacity-80 text-text-contrast">
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.help-center') }}</a></li>
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.privacy-policy') }}</a></li>
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.terms') }}</a></li>
            </ul>
        </div>

    </div>

    <div class="font-montserrat text-text-contrast border-t border-white/20 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center text-sm opacity-70">
        <p>{{ __('main.footer.rights') }}</p>

        <p>{{ __('main.footer.platform') }}</p>
    </div>
</footer>