const contactForm = document.querySelector("#contact");
const contactTable = document.querySelector(".table");
const tableCaption = document.querySelector("#table-caption");
const searchInput = document.querySelector("input#search");

document.addEventListener("DOMContentLoaded", () =>
{
    contactForm.addEventListener("submit", onFormSubmit);
    contactTable.addEventListener("click", contactsHandler);
    searchInput.addEventListener("input", searchContact);
});


//
function onFormSubmit(e)
{
    e.preventDefault();

    //
    const nombre = document.querySelector("#nombre").value;
    const compania = document.querySelector("#compania").value;
    const telefono = document.querySelector("#telefono").value;
    const accion = document.querySelector("#accion").value;

    if(nombre === '' || compania === '' || telefono === '') return;
    else
    {
        const form = new FormData();
        form.append("nombre", nombre);
        form.append("compania", compania);
        form.append("telefono", telefono);
        form.append("accion", accion);

        if(accion === "crear")
        {
            createContact(form);
        }
    }
}


function createContact(form)
{
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/crear", true);
    xhr.send(form);

    xhr.onload = function()
    {
        if(this.status === 200)
        {
            const contact = JSON.parse(xhr.responseText);

            // Contacto creado correctamente
            if(contact.response === 200)
            {
                // Agregar contacto al final del <table>
                const tableBody = document.querySelector("#contacts-table-body");

                const tr = document.createElement("TR");
                tr.setAttribute("contact-id", contact.id);
                tr.innerHTML = 
                `
                    <td id="nombre">${contact.nombre}</td>
                    <td id="compania">${contact.compania}</td>
                    <td id="telefono">${contact.telefono}</td>
                    <td>
                        <button id="contact-edit-btn" class="contact-action-btn" title="Editar">
                            <i class="icon far fa-edit"></i>
                        </button>

                        <button id="contact-delete-btn" class="contact-action-btn" title="Eliminar">
                            <i class="icon fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);

                // Contar cantidad de contactos
                const count = document.querySelectorAll(".table tbody tr").length;
                tableCaption.textContent = `${count} contactos`;

                document.querySelector(".has-no-contacts").classList.add("d-none");
                document.querySelector(".has-contacts").classList.remove("d-none");

                // Resetear inputs del form
                contactForm.reset();
            }
        }
    }
}


//
let editing = false;
let originalTR = "";

function contactsHandler(e)
{
    const btn = e.target.parentElement; // <button>
    if(btn.id === "contact-edit-btn") // Editar
    {
        // Verificar si ya está editando otro contacto
        // cancelar la acción
        if(editing)
        {
            document.querySelector("#cancelBtn").click();
        }

        //
        const tr = btn.parentElement.parentElement; // Obtener el <tr>
        const id = tr.getAttribute("contact-id"); // <tr contact-id>

        editing = true;
        originalTR = tr.innerHTML;

        // Editar HTML
        const nombre = tr.querySelector("#nombre").textContent;
        const compania = tr.querySelector("#compania").textContent;
        const telefono = tr.querySelector("#telefono").textContent;

        tr.innerHTML = 
        `
            <form>
                <td><input id="newNombre" class="form-control" type="text" placeholder="Nombre" value="${nombre}" required></td>
                <td><input id="newCompania" class="form-control" type="text" placeholder="Compañia" value="${compania}" required></td>
                <td><input id="newTelefono" class="form-control" type="tel" placeholder="Teléfono" value="${telefono}" required></td>
                <td class="d-flex justify-content-start gap-1">
                    <button id="saveBtn" class="btn btn-success" type="submit">Guardar</button>
                    <button id="cancelBtn" class="btn btn-outline-light" type="submit">Cancelar</button>
                </td>
            </form>
        `;

        // Botones de guardar/cancelar
        const saveBtn = tr.querySelector("#saveBtn");
        const cancelBtn = tr.querySelector("#cancelBtn");

        // Guardar
        saveBtn.onclick = function(e)
        {
            e.preventDefault();

            // Extrar valores
            const nombre = document.querySelector("#newNombre").value;
            const compania = document.querySelector("#newCompania").value;
            const telefono = document.querySelector("#newTelefono").value;

            const form = new FormData();
            form.append("id", id);
            form.append("nombre", nombre);
            form.append("compania", compania);
            form.append("telefono", telefono);

            editContact(form, tr);
            //cancelBtn.click();
        }

        // Cancelar
        cancelBtn.onclick = function()
        {
            tr.innerHTML = originalTR; // Insertar el TR original
            editing = false;
        }
    }
    else if(btn.id === "contact-delete-btn") // Eliminar
    {
        if(editing)
        {
            alert("Termina de editar el contacto actual");
            return;
        }

        if(confirm("¿Seguro que quieres eliminar este contacto? Esta acción es irreversible!"))
        {
            const id = btn.parentElement.parentElement.getAttribute("contact-id"); // Extraer el id desde el <tr>
            deleteContact(id);
        }
    }
}

function editContact(form, tr)
{
    // Form
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/editar", true);
    xhr.send(form);

    xhr.onload = function()
    {
        // Peticion exitosa
        if(this.status === 200)
        {
            const contact = JSON.parse(xhr.responseText);

            // Contacto editado correctamente
            if(contact.response === 100)
            {
                // Terminar la edición
                tr.querySelector("#cancelBtn").click();

                // Editar <tr>
                tr.innerHTML =
                `
                    <td id="nombre">${contact.nombre}</td>
                    <td id="compania">${contact.compania}</td>
                    <td id="telefono">${contact.telefono}</td>
                    <td>
                        <button id="contact-edit-btn" class="contact-action-btn" title="Editar">
                            <i class="icon far fa-edit"></i>
                        </button>

                        <button id="contact-delete-btn" class="contact-action-btn" title="Eliminar">
                            <i class="icon fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
            }
        }
    }
    //
}


function deleteContact(id)
{
    // Form
    const form = new FormData();
    form.append("id", id);

    // Request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/eliminar", true);
    xhr.send(form);

    xhr.onload = function()
    {
        if(this.status === 200)
        {
            const response = JSON.parse(xhr.responseText);

            // Eliminado correctamente desde la db
            if(response === 100)
            {
                const tr = document.querySelector(`tr[contact-id="${id}"]`);
                tr.remove(); // Eliminar <tr>

                // Contar cantidad de contactos
                const count = document.querySelectorAll(".table tbody tr").length;
                tableCaption.textContent = `${count} contactos`;

                if(count === 0)
                {
                    document.querySelector(".has-no-contacts").classList.remove("d-none");
                    document.querySelector(".has-contacts").classList.add("d-none");
                }
            }
        }
    }
    //
}


function searchContact()
{
    let count = 0;
    const exp = new RegExp(searchInput.value, "i");
    const regs = document.querySelectorAll(".table tbody tr");

    regs.forEach(reg =>
    {
        reg.style.display = "none"; // Ocultar elementos por default

        const nombre = reg.childNodes[1].textContent.replace(/\s/g, " ").search(exp) != -1;
        const compania = reg.childNodes[3].textContent.replace(/\s/g, " ").search(exp) != -1;
        const telefono = reg.childNodes[5].textContent.replace(/\s/g, " ").search(exp) != -1;

        if(nombre || compania || telefono) // Un contacto coincide con la busqueda
        {
            reg.style.display = "table-row"; // Mostrar elemento
            count++;

            tableCaption.textContent = `${count} resultados filtrados`;
        }
    });

    if(count === 0) // Sin resultados
    {
        tableCaption.textContent = "Sin resultados";
    }
    if(searchInput.value === "") // Input vacio
    {
        tableCaption.textContent = `${count} contactos`;
    }
}