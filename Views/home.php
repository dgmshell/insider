<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Pivot Dinámica</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Tabla Dinámica (Pivot) con Datos</h1>

<div>
    <label for="rows">Selecciona filas:</label>
    <select id="rows" multiple onchange="generatePivot()"></select>
</div>

<div>
    <label for="columns">Selecciona columnas:</label>
    <select id="columns" multiple onchange="generatePivot()"></select>
</div>

<div>
    <label for="values">Selecciona valores:</label>
    <select id="values" multiple onchange="generatePivot()"></select>
</div>

<h2>Tabla Pivot Generada</h2>
<div id="pivotTable"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>

<script>
    // Datos proporcionados
    const data = [
        { "first_name": "Ana", "last_name": "Barravino", "project": "Debt - C2C Koji - Sp", "phone": "5595742025", "company": "HFG 2020", "state": "CA", "amount": "$11,526.00" },
        { "first_name": "Ignacio", "last_name": "Paredes", "project": "English LT- 02", "phone": "4806130966", "company": "DMB", "state": "AZ", "amount": "$11,689.21" },
        { "first_name": "Yohn", "last_name": "Gutierrez", "project": "Debt C2C SP - HFG - MP", "phone": "4045572942", "company": "SIBERT", "state": "GA", "amount": "$26,115.00" },
        { "first_name": "Kwame", "last_name": "Moorer", "project": "Debt C2C - HFG - MP", "phone": "4696165483", "company": "DMB", "state": "TX", "amount": "$12,076.00" },
        { "first_name": "Rebeca", "last_name": "Lombardi", "project": "Debt - C2C Koji - Sp", "phone": "9703555990", "company": "SIBERT", "state": "CO", "amount": "$25,713.00" },
        { "first_name": "Alberto", "last_name": "conde", "project": "Debt C2C SP - HFG - MP", "phone": "2132781196", "company": "DMB", "state": "CA", "amount": "$14,507.00" },
        { "first_name": "Angel", "last_name": "Perez", "project": "Debt - C2C Koji - Sp", "phone": "9097469887", "company": "DMB", "state": "CA", "amount": "$14,596.00" },
        { "first_name": "Altan", "last_name": "Erskine", "project": "Debt C2C - HFG - MP", "phone": "6619024349", "company": "DMB", "state": "CA", "amount": "$15,395.00" },
        { "first_name": "Ana", "last_name": "Barravino", "project": "Debt - C2C Koji - Sp", "phone": "6465152234", "company": "DMB", "state": "NY", "amount": "$17,323.00" },
        { "first_name": "Mario", "last_name": "Stewart", "project": "Debt C2C - HFG - Fitz", "phone": "3144896983", "company": "DMB", "state": "MO", "amount": "$19,854.00" },
        { "first_name": "William", "last_name": "King", "project": "Debt C2C - HFG - MP", "phone": "3055041072", "company": "DMB", "state": "FL", "amount": "$35,045.00" },
        { "first_name": "Alberto", "last_name": "Conde", "project": "referral", "phone": "2134548275", "company": "DMB", "state": "CA", "amount": "$11,886.01" },
        { "first_name": "Carmelina", "last_name": "Lopez", "project": "Debt - C2C Koji - Sp", "phone": "7863328965", "company": "DMB", "state": "FL", "amount": "$15,426.00" },
        { "first_name": "Claudia", "last_name": "Moreno", "project": "Debt - C2C Koji - Sp", "phone": "8315245830", "company": "DMB", "state": "TX", "amount": "$11,903.00" },
        { "first_name": "Carmelina", "last_name": "Lopez", "project": "Debt C2C - Avanto SP", "phone": "4028139070", "company": "DMB", "state": "NE", "amount": "$34,553.10" },
        { "first_name": "William", "last_name": "King", "project": "Debt C2C - HFG - MP", "phone": "3364560919", "company": "DMB", "state": "NC", "amount": "$20,202.00" }
    ];

    // Función para llenar los select con las opciones
    function populateSelectors() {
        const keys = Object.keys(data[0]);

        const rowSelect = document.getElementById("rows");
        const columnSelect = document.getElementById("columns");
        const valueSelect = document.getElementById("values");

        keys.forEach(key => {
            let option = document.createElement("option");
            option.value = key;
            option.textContent = key;
            rowSelect.appendChild(option);
            columnSelect.appendChild(option.cloneNode(true));
            valueSelect.appendChild(option.cloneNode(true));
        });
    }

    // Función para generar la tabla dinámica
    // Función para generar la tabla dinámica
    function generatePivot() {
        const rows = Array.from(document.getElementById("rows").selectedOptions).map(option => option.value);
        const columns = Array.from(document.getElementById("columns").selectedOptions).map(option => option.value);
        const values = Array.from(document.getElementById("values").selectedOptions).map(option => option.value);

        const groupedData = _.groupBy(data, item => {
            return rows.map(row => item[row]).join('-');
        });

        const pivotTable = {};

        // Si se seleccionaron solo filas, mostrar los datos de las filas
        if (rows.length > 0 && columns.length === 0 && values.length === 0) {
            renderRows(groupedData);
            return;
        }

        // Crear la estructura de la tabla pivote si hay columnas y valores seleccionados
        Object.keys(groupedData).forEach(rowKey => {
            const group = groupedData[rowKey];
            columns.forEach(column => {
                const columnValues = _.groupBy(group, item => item[column]);
                Object.keys(columnValues).forEach(colKey => {
                    pivotTable[rowKey] = pivotTable[rowKey] || {};
                    pivotTable[rowKey][colKey] = columnValues[colKey].reduce((sum, item) => {
                        // Comprobar que el valor existe y es un número antes de intentar sumarlo
                        const value = item[values[0]];
                        if (value && !isNaN(value.replace(/[^\d.-]/g, ''))) {
                            return sum + parseFloat(value.replace(/[^\d.-]/g, ''));
                        }
                        return sum;
                    }, 0);
                });
            });
        });

        // Renderizar la tabla generada
        renderPivotTable(pivotTable);
    }


    // Función para renderizar solo filas
    function renderRows(groupedData) {
        const tableContainer = document.getElementById("pivotTable");
        tableContainer.innerHTML = ""; // Limpiar tabla existente

        const table = document.createElement("table");
        const thead = document.createElement("thead");
        const tbody = document.createElement("tbody");

        // Crear la cabecera de la tabla
        const headerRow = document.createElement("tr");
        const rowHeader = document.createElement("th");
        rowHeader.textContent = "Filas";
        headerRow.appendChild(rowHeader);
        thead.appendChild(headerRow);

        // Crear las filas de datos
        Object.keys(groupedData).forEach(rowKey => {
            const tr = document.createElement("tr");
            const th = document.createElement("th");
            th.textContent = rowKey;
            tr.appendChild(th);
            tbody.appendChild(tr);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableContainer.appendChild(table);
    }

    // Función para renderizar la tabla generada
    function renderPivotTable(pivotTable) {
        const tableContainer = document.getElementById("pivotTable");
        tableContainer.innerHTML = ""; // Limpiar tabla existente

        const table = document.createElement("table");
        const thead = document.createElement("thead");
        const tbody = document.createElement("tbody");

        // Crear la cabecera de la tabla
        const headerRow = document.createElement("tr");
        const rowHeader = document.createElement("th");
        rowHeader.textContent = "Filas/Columnas";
        headerRow.appendChild(rowHeader);

        const columns = Object.keys(pivotTable).reduce((cols, rowKey) => {
            Object.keys(pivotTable[rowKey]).forEach(colKey => {
                if (!cols.includes(colKey)) cols.push(colKey);
            });
            return cols;
        }, []);

        columns.forEach(col => {
            const th = document.createElement("th");
            th.textContent = col;
            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);

        // Crear las filas de datos
        Object.keys(pivotTable).forEach(rowKey => {
            const tr = document.createElement("tr");
            const th = document.createElement("th");
            th.textContent = rowKey;
            tr.appendChild(th);

            columns.forEach(col => {
                const td = document.createElement("td");
                td.textContent = pivotTable[rowKey][col] || 0;
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableContainer.appendChild(table);
    }

    // Inicializar selectores
    populateSelectors();
</script>

</body>
</html>
