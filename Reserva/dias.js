const contenedores = document.querySelectorAll("#cuadrarfechas .fecha");
const hoy = new Date();

function formatear(fecha) {
    return fecha.toLocaleDateString("es-ES", {
        weekday: "long", day: "numeric", month: "long"
    });
}

function toISO(fecha) {
    const yyyy = fecha.getFullYear();
    const mm = String(fecha.getMonth() + 1).padStart(2, "0");
    const dd = String(fecha.getDate()).padStart(2, "0");
    return `${yyyy}-${mm}-${dd}`;
}

const params = new URLSearchParams(window.location.search);
const diaActivo = params.get("dia") || toISO(hoy);

contenedores.forEach((div, i) => {
    const fecha = new Date();
    fecha.setDate(hoy.getDate() + i);
    const enlace = div.querySelector("a");
    enlace.textContent = formatear(fecha);
    enlace.href = `reserva.php?dia=${toISO(fecha)}`;
    if (toISO(fecha) === diaActivo) {
        enlace.classList.add("activo");
    }
});