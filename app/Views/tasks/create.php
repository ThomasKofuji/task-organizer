<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5 bg-dark text-white rounded-4 d-flex flex-column justify-content-around align-items-center" style="width: 70vw;">
    <div class="row" style="width: 60vw;">
        <div class="col">

            <h1 class="text-center mb-4 mt-4">Cadastrar Tarefa</h1>

            <?= form_open('/submit', ['novalidate' => true]) ?>

                <div class="mb-5">
                    <label for="title" class="form-label">Título *</label>
                    <input type="text" class="form-control" id="title" name="title" required value="<?= old('title') ?>">
                </div>

                <div class="mb-5">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" name="description" id="description"><?= old('description') ?></textarea>
                </div>

                <div class="mb-5">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pendente" <?= old('status', 'pendente') === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="em_andamento" <?= old('status') === 'em_andamento' ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="concluida" <?= old('status') === 'concluida' ? 'selected' : '' ?>>Concluída</option>
                    </select>
                </div>

                <div class="mb-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg w-50">Salvar</button>
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary btn-lg w-50">Voltar</a>
                </div>

            <?= form_close() ?>  

            <?php if(!empty($validation_errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach($validation_errors as $error): ?>
                            <li><?= $error ?></li>    
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success mt-3 text-center">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif ?>

        </div>
    </div>
</div>
<?php $this->endSection() ?>