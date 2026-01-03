<x-layouts.app>
    <div class="p-8">
        <h1 class="text-4xl font-bold mb-4">تست فونت ایران یکان</h1>
        <p class="text-lg mb-4">این متن باید با فونت ایران یکان نمایش داده شود.</p>
        <p class="text-base mb-4">۱۲۳۴۵۶۷۸۹۰ - اعداد فارسی</p>
        <p class="text-base mb-4">abcdefghijklmnopqrstuvwxyz - حروف انگلیسی</p>
        <p class="text-base mb-4 font-iran">این متن با کلاس font-iran</p>
        
        <div class="mt-8 p-4 bg-blue-100 rounded">
            <h2 class="text-xl font-semibold mb-2">اطلاعات فونت:</h2>
            <p>نام فونت: IRANYekan</p>
            <p>مسیر: {{ asset('fonts/IRANYekanXVF.woff2') }}</p>
        </div>
        
        <script>
            // بررسی لود شدن فونت
            document.fonts.ready.then(function() {
                console.log('Fonts loaded');
                document.fonts.forEach(function(font) {
                    console.log('Font:', font.family, font.style, font.weight);
                });
            });
        </script>
    </div>
</x-layouts.app>