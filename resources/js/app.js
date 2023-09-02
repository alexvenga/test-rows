import './bootstrap';

import Alpine from 'alpinejs'

import excelRowsTable from './alpine/excel-rows-table';

Alpine.data('excelRowsTable', excelRowsTable);

window.Alpine = Alpine

Alpine.start()
