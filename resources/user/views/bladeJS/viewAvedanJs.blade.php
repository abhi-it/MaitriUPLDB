@push('body-scripts')
    <script>
        // alert('ok');
        document.addEventListener('alpine:init', () => {
            Alpine.data('viewAvedan', () => ({
                init() {
                    this.parseQueryParams();
                    if (this.queryParams['district_id']) {
                        this.selectedDistrict = this.queryParams['district_id'];
                        this.onChangeDistrict();
                    }
                },
                selectedDistrict: '',
                selectedBlock: '',
                selectedCategory: '',
                vikasKhand: [],
                districts: {{ Js::from($districts) }} ?? [],
                categories: [
                    'जनरल',
                    'ओ बी सी',
                    'एस सी',
                    'एस टी'
                ],
                queryParams: {},
                responseData: '',

                parseQueryParams() {
                    const urlSearchParams = new URLSearchParams(window.location.search);
                    const params = Object.fromEntries(urlSearchParams.entries());
                    this.queryParams = params;
                },
                onChangeDistrict() {
                    const queryParams = {
                        districtId: this.selectedDistrict ? this.selectedDistrict : null,
                    };
                    axios.get('{{ route('getVikaskhand') }}', {
                            params: queryParams
                        })
                        .then(response => {
                            this.vikasKhand = response.data.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }));
        });
    </script>
@endpush
