import $ from 'jquery';
import select2 from 'select2';
import duallistbox from 'bootstrap4-duallistbox';
import 'select2/dist/css/select2.css';
import 'bootstrap4-duallistbox/dist/bootstrap-duallistbox.css';

window.$ = window.jQuery = $;
select2(window, $);
duallistbox(window, $);

$(function () {
    $('#filters').select2({
        width: '100%',
        placeholder: 'Оберіть мітки',
    });

    $('#features').select2({
        width: '100%',
        placeholder: 'Оберіть опції',
    });

    $('#duallist').bootstrapDualListbox({
        nonSelectedListLabel: 'Доступні мітки',
        selectedListLabel: 'Обрані мітки',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: false,
        infoText: 'Усього {0}',
        filterPlaceHolder: 'Пошук',
    });
});
