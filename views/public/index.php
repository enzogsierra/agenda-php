<header class="header-hero">
    <div class="container header">
        <h1 class="header-h1">
            <a href="/">Agenda de contactos</a>
        </h1>
    </div>
</header>

<!-- Añadir contacto -->
<main class="container bg-white section">
    <h2 class="my-0 text-center">Añadir un nuevo contacto</h2>
    <p class="my-0 text-center text-muted">* Todos los campos son obligatorios</p>
    
    <form id="contact" class="form" action="#" method="POST">    
        <fieldset class="contact-add-fieldset my-4 d-flex justify-content-spacebetween gap-3">
            <div class="col">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="nombre" placeholder="Messi" class="form-control" required>
            </div>

            <div class="col">
                <label for="compania" class="form-label">Compañía</label>
                <input type="text" id="compania" placeholder="Messi Corp" class="form-control" required>
            </div>

            <div class="col">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" id="telefono" placeholder="1234-567890" class="form-control" required>
                <p class="form-text">No es necesario incluir el código de país (+54).</p>
            </div>
        </fieldset>

        <input type="hidden" id="accion" value="crear">
        <div class="contact-add-btn text-end">
            <button type="submit" class="btn btn-primary">Añadir</button>
        </div>
    </form>
</main>

<!-- Lista de contactos -->
<section class="container bg-white section">
    <h2 class="my-0 text-center">Contactos</h2>

    <!-- Sin contactos -->
    <div class="has-no-contacts <?php echo (count($contacts) ?  "d-none" : ""); ?>">
        <p class="text-center text-muted my-4">Aún no tienes contactos agendados!</p>
    </div>

    <!-- Con contactos -->
    <div class="has-contacts <?php echo (!count($contacts) ?  "d-none" : ""); ?>">
        <div class="contacts-search d-flex my-0 py-4">
            <input id="search" class="form-control me-2" type="search" placeholder="Buscar contacto por nombre, compañía o teléfono" aria-label="Search" required>
        </div>

        <table class="table table-dark table-striped table-borderless caption-top mb-0">
            <caption id="table-caption"><?php echo count($contacts); ?> contactos</caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="contacts-table-body">
                <?php foreach($contacts as $contact): ?>
                    <tr contact-id="<?php echo $contact["id"]; ?>">
                        <td id="nombre"><?php echo $contact["nombre"]; ?></td>
                        <td id="compania"><?php echo $contact["compania"]; ?></td>
                        <td id="telefono"><?php echo $contact["telefono"]; ?></td>
                        <td>
                            <button id="contact-edit-btn" class="contact-action-btn" title="Editar">
                                <i class="icon far fa-edit"></i>
                            </button>

                            <button id="contact-delete-btn" class="contact-action-btn" title="Eliminar">
                                <i class="icon fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>