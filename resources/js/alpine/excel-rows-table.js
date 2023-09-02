import dateFormat, { masks } from "dateformat";

export default (rows) => ({

    excelRows: [],

    init() {

        this.excelRows = rows;

        Echo.channel('excel-rows')
            .listen('ExcelRowCreatedEvent', (e) => {
                this.addData(e.excelRow);
            });

    },

    addData(data) {
        let date = dateFormat((new Date(Date.parse(data.date))), "yyyy-mm-dd");
        if (typeof this.excelRows[date] === "undefined" ) {
            this.excelRows[date] = 0;
        }
        this.excelRows[date]++;
    }

})
