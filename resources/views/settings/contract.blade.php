<!doctype html>
<html lang="{{\Illuminate\Support\Facades\App::getLocale()}}" dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('assets/css/core/print.css')}}">
    <style>
        .pageFooter{
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            opacity: 0;
        }
        @media print {
            .header{
                display: none;
            }
            .tableFooter{
                opacity: 0;
            }
            .pageFooter{
                opacity: 100;
            }
        }
    </style>
</head>
<body style="min-height: 297mm;width: 210mm;margin:auto">

        <table style="width: 100%">
            <thead>
                <th>
                    <img src="{{ asset('storage/'.(auth()->user()->ownerable?->receipt_header ?? \App\Models\Logistic\Branch::find(1)?->receipt_header))  }}" style="width: 100%;">
                </th>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 10px;line-height: 1.8">
                        {!! $data !!}
                    </td>
                </tr>
            </tbody>
            <tfoot class="tableFooter">
                <th>
                    <img src="{{ asset('storage/'.(auth()->user()->ownerable?->receipt_footer?? \App\Models\Logistic\Branch::find(1)?->receipt_footer))  }}" style="width: 100%;">
                </th>
            </tfoot>
        </table>
        <img class="pageFooter" src="{{ asset('storage/'.(auth()->user()->ownerable?->receipt_footer?? \App\Models\Logistic\Branch::find(1)?->receipt_footer))  }}" style="width: 100%;">

</body>
<script>
    window.print();
    window.onafterprint = function() {
        history.back();
    };
</script>
</html>
