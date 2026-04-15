/* ============================
   RELLENAR FECHAS ARRIBA DESDE HOY
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

// Generar HOY → HOY+4
contenedores.forEach((div, i) => {
    const fecha = new Date();
    fecha.setDate(hoy.getDate() + i);

    div.querySelector("a").textContent = formatear(fecha);
    div.dataset.fecha = fecha.toLocaleDateString("es-ES");
});


/* ============================
   MARCAR EL DÍA DE LA RESERVA (SI ESTÁ EN EL RANGO)
   ============================ */

let diaSeleccionado = localStorage.getItem("dia"); // ej: "11/02/2026"

if (diaSeleccionado) {

    // Convertimos la fecha guardada a Date
    let [d, m, a] = diaSeleccionado.split("/").map(Number);
    let fechaReserva = new Date(a, m - 1, d);

    // Quitamos activo de todos
    document.querySelectorAll("#cuadrarfechas a").forEach(a => a.classList.remove("activo"));

    // Buscar si la fecha de la reserva coincide con alguno de los 5 días
    const enlaces = document.querySelectorAll("#cuadrarfechas .fecha");

    enlaces.forEach((div, i) => {
        let [dd, mm, aa] = div.dataset.fecha.split("/").map(Number);
        let fechaBoton = new Date(aa, mm - 1, dd);

        if (fechaBoton.getTime() === fechaReserva.getTime()) {
            div.querySelector("a").classList.add("activo");
        }
    });
}


/* ============================
   RESTO DE TU SCRIPT (SIN CAMBIOS)
   ============================ */

// Texto de confirmación
let dia = localStorage.getItem("dia");
let hora = localStorage.getItem("hora");
let pista = localStorage.getItem("pista");

document.querySelector(".fechayhora").textContent =
    `El ${dia} a las ${hora} en ${pista}`;

// Calcular hora de fin (90 minutos)
function sumarMinutos(hora, minutos) {
    let [h, m] = hora.split(":").map(Number);
    m += minutos;
    h += Math.floor(m / 60);
    m = m % 60;
    return `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
}

let horaFin = sumarMinutos(hora, 90);

function obtenerDiaSemana(fechaTexto) {
    let [dia, mes, año] = fechaTexto.split("/").map(Number);
    let fecha = new Date(año, mes - 1, dia);
    return fecha.toLocaleDateString("es-ES", { weekday: "long" });
}

let diaSemana = obtenerDiaSemana(dia);

document.querySelector("#infohorario p").innerHTML =
    `<b>Inicio:</b><br>El ${diaSemana} a las ${hora}`;

document.querySelector(".finpartida").innerHTML =
    `<b>Fin:</b><br>El ${diaSemana} a las ${horaFin}`;

// Mostrar pista
document.addEventListener("DOMContentLoaded", () => {
    const pista = localStorage.getItem("pista");
    document.getElementById("nombrePista").textContent = pista;

    const img = document.getElementById("imagenPista");

    if (pista === "Pista 1") {
        img.src = "../Imágenes/pista1.jpg";
        img.alt = "Imagen de la pista 1";
    } else if (pista === "Pista 2") {
        img.src = "../Imágenes/pista2.jpg";
        img.alt = "Imagen de la pista 2";
    }
});
document.getElementById("inscribirse").addEventListener("click", () => {

    // Rellenar los inputs ocultos
    document.getElementById("diaInput").value = localStorage.getItem("dia");
    document.getElementById("horaInput").value = localStorage.getItem("hora");
    document.getElementById("horaFinInput").value = horaFin;
    document.getElementById("pistaInput").value = localStorage.getItem("pista");

    // Datos del selector
    document.getElementById("nivelInput").value = document.getElementById("nivel").value;
    document.getElementById("jugadoresInput").value = document.getElementById("jugadores").value;

    // Enviar formulario
    document.getElementById("formReserva").submit();
});
