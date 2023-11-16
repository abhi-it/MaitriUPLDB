@push('body-scripts')
    <script>
        // alert('ok');
        document.addEventListener('alpine:init', () => {
            Alpine.data('viewAvedanDistrictwise', () => ({
                init() {
                    this.parseQueryParams();



                    const currentPath = window.location.pathname;

                    // Extract the path variable
                    const pathParts = currentPath.split('/');
                    const yourPathVariable = pathParts[
                        2]; // Adjust the index based on your URL structure

                    const currentYear = new Date().getFullYear();
                    this.sessionYear = `${yourPathVariable}` ? parseInt(yourPathVariable) :  currentYear;
                    if (this.queryParams['district_id']) {
                        this.selectedDistrict = this.queryParams['district_id'];
                        this.onChangeDistrict();
                    }

                },
                sessionYear: '',
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
                        sessionYear: this.sessionYear
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
