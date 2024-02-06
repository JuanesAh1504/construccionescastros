
/* Se añade fila  precioUnitarioFinal*/
ALTER TABLE cotizacion
ADD precioUnitarioFinal VARCHAR(50) AFTER totalPorTodoTablaInput;
/* Se crea fila para guardar los datos dinámicos */
ALTER TABLE cotizacion
ADD precioUnitarioFinalValores VARCHAR(50) AFTER totalValores;