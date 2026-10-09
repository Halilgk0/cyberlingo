<x-error-page code="419" title="Sayfanın süresi doldu" :action-url="url()->previous(route('missions.index'))" action-label="Geri dön ve tekrar dene">
    Güvenliğin için formlar bir süre sonra geçersiz olur. Geri dönüp sayfayı yenile, sonra tekrar dene.
</x-error-page>
