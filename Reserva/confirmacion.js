document.addEventListener("DOMContentLoaded", () => {

/* ============================
   RELLENAR FECHAS ARRIBA DESDE HOY
   ============================ */

const contenedores = document.querySelectorAll("#dias .fecha");
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
    div.dataset.fecha = fecha.toLocaleDateString("es-ES");
});

/* ============================
   MARCAR EL DÍA DE LA RESERVA
   ============================ */

// Leer dia desde la URL (formato 2026-02-10)
const params = new URLSearchParams(window.location.search);
const diaURL = params.get("dia");     // "2026-02-10"
const horaURL = params.get("hora");   // "09:00"
const pistaURL = params.get("pista"); // "1"

if (diaURL) {
    let [a, m, d] = diaURL.split("-").map(Number);
    let fechaReserva = new Date(a, m - 1, d);

    document.querySelectorAll("#dias a").forEach(a => a.classList.remove("activo"));

    document.querySelectorAll("#dias .fecha").forEach((div) => {
        let [dd, mm, aa] = div.dataset.fecha.split("/").map(Number);
        let fechaBoton = new Date(aa, mm - 1, dd);
        if (fechaBoton.getTime() === fechaReserva.getTime()) {
            div.querySelector("a").classList.add("activo");
        }
    });
}

/* ============================
   CALCULAR HORA FIN
   ============================ */

function sumarMinutos(hora, minutos) {
    let [h, m] = hora.split(":").map(Number);
    m += minutos;
    h += Math.floor(m / 60);
    m = m % 60;
    return `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
}

let horaFin = horaURL ? sumarMinutos(horaURL, 90) : "";

/* ============================
   BOTÓN INSCRIBIRSE
   ============================ */

document.getElementById("inscribirse").addEventListener("click", () => {
    // Convertir fecha de URL (2026-02-10) a formato dd/mm/yyyy para la BD
    let [a, m, d] = diaURL.split("-").map(Number);
    let diaFormateado = `${String(d).padStart(2,"0")}/${String(m).padStart(2,"0")}/${a}`;

    document.getElementById("diaInput").value = diaURL;
    document.getElementById("horaInput").value = horaURL;
    document.getElementById("horaFinInput").value = horaFin;
    document.getElementById("pistaInput").value = pistaURL;
    document.getElementById("nivelInput").value = document.getElementById("nivel").value;
    document.getElementById("jugadoresInput").value = document.getElementById("jugadores").value;

    document.getElementById("formReserva").submit();
});

});