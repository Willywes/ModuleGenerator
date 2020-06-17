<script>

    function copyContentRoutes() {
        $('#contentRoutes').select();
        document.execCommand('copy');
    }

    function createRoutes() {
        let html = '';
        data.module_routes.forEach((item) => {

            let name = getCleanRouteName(item.name);
            let url = '/' + (data.base_route).replace('.', '/') + '/';
            if (name == 'show' || name == 'update' || name == 'destroy') {
                url += '{id}'
            }
            if (name == 'edit') {
                url += '{id}/edit'
            }
            html += 'Route::' + item.method + '(\'' + url + '\', \'' + item.controller + '\')->name(\'' + item.name + '\');\n';

        });
        $('#contentRoutes').html(html);
    }


</script>
