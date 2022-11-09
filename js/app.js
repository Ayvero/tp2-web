"use strict"

const URL = "api/tasks/";

let tasks = [];

let form = document.querySelector('#task-form');
form.addEventListener('submit', insertTask);


/**
 * Obtiene todas las tareas de la API REST
 */
async function getAll() {
    try {
        let response = await fetch(URL);
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }
        tasks = await response.json();

        showTasks();
    } catch(e) {
        console.log(e);
    }
}

/**
 * Inserta la tarea via API REST
 */
async function insertTask(e) {
    e.preventDefault();
    
    let data = new FormData(form);
    let task = {
        titulo: data.get('titulo'),
        descripcion: data.get('descripcion'),
        prioridad: data.get('prioridad'),
    };

    try {
        let response = await fetch(URL, {
            method: "POST",
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(task)
        });
        if (!response.ok) {
            throw new Error('Error del servidor');
        }

        let nTask = await response.json();

        // inserto la tarea nuevo
        tasks.push(nTask);
        showTasks();

        form.reset();
    } catch(e) {
        console.log(e);
    }
} 

async function deleteTask(e) {
    e.preventDefault();
    try {
        let id = e.target.dataset.task;
        let response = await fetch(URL + id, {method: 'DELETE'});
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }

        // eliminar la tarea del arreglo global
        tasks = tasks.filter(task => task.id != id);
        showTasks();
    } catch(e) {
        console.log(e);
    }
}

function showTasks() {
    let ul = document.querySelector("#task-list");
    ul.innerHTML = "";
    for (const task of tasks) {

        let html = `
            <li class='
                    list-group-item d-flex justify-content-between align-items-center
                    ${ task.finalizada == 1 ? 'finalizada' : ''}
                '>
                <span> <b>${task.titulo}</b> - ${task.descripcion} (prioridad ${task.prioridad}) </span>
                <div class="ml-auto">
                    ${task.finalizada != 1 ? `<a href='#' data-task="${task.id}" type='button' class='btn btn-success btn-finalize'>Finalizar</a>` : ''}
                    <a href='#' data-task="${task.id}" type='button' class='btn btn-danger btn-delete'>Borrar</a>
                </div>
            </li>
        `;

        ul.innerHTML += html;
    }

    // asigno event listener para los botones
    const btnsDelete = document.querySelectorAll('a.btn-delete');
    for (const btnDelete of btnsDelete) {
        btnDelete.addEventListener('click', deleteTask);
    }
}

getAll();