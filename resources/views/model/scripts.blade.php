<script>

    function copyContentClass() {
        $('#contentClass').select();
        document.execCommand('copy');
    }



    function createClass() {


        let header = 'namespace App\\Models;\n' +
            'use Illuminate\\Database\\Eloquent\\Model;\n\n';

        let body = '';

        // options
        body += '    protected $fillable = [\n' +

            '    ];\n\n';


        let classBuild = '<' + '?php\n\n' + header;
        classBuild += 'class ' + data.class + ' extends Model\n' +
            '{\n' + body + '\n' +
            '}\n';

        $('#contentClass').html(classBuild);
    }


</script>
