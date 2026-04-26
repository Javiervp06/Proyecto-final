/* ============================
   1. RELLENAR FECHAS ARRIBA (DINÁMICO DESDE HOY)
   ============================ */

const contenedores = document.querySelectorAll("#cuadrarfechas .fecha");
const hoy = new Date();

function formatear(fecha) {
    return fecha.toLocaleDateString("es-ES", {
        weekday: "long",
        day: "numeric",
        month: "long"
    });
}

contenedores.forEach((div, i) => {
    const fecha = new Date();
    fecha.setDate(hoy.getDate() + i);
    div.querySelector("a").textContent = formatear(fecha);

    // Guardamos la fecha real en cada botón
    div.dataset.fecha = fecha.toLocaleDateString("es-ES");
});


/* ============================
   2. MARCAR EL DÍA ACTIVO SEGÚN LA PÁGINA
   ============================ */

const archivo = location.pathname.split("/").pop();

const mapa = {
    "reserva.php": 0,
    "dia2.php": 1,
    "dia3.php": 2,
    "dia4.php": 3,
    "dia5.php": 4
};

const indiceActivo = mapa[archivo];

if (indiceActivo !== undefined) {
    document.querySelectorAll("#cuadrarfechas .fecha a")
        .forEach(a => a.classList.remove("activo"));

    document.querySelectorAll("#cuadrarfechas .fecha a")[indiceActivo]
        .classList.add("activo");
}

