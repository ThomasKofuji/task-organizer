<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Minhas Tarefas</h1>
        <a href="<?= base_url('/create') ?>" class="btn btn-primary">Nova Tarefa</a>
    </div>

    <div class="card shadow-sm ">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Criado em</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($tasks) && is_array($tasks)): ?>
                        <?php foreach($tasks as $task): ?>
                            <!-- Tiramos o data-bs-toggle do <tr> e colocamos nas <td> individuais -->
                            <tr class="align-middle" style="cursor: pointer;" title="Clique nas informações para expandir/recolher a descrição">
                                
                                <td data-bs-toggle="collapse" data-bs-target="#desc-<?= $task['id'] ?>"><?= $task['id'] ?></td>
                                
                                <td data-bs-toggle="collapse" data-bs-target="#desc-<?= $task['id'] ?>"><strong><?= esc($task['title']) ?></strong></td>
                                
                                <td data-bs-toggle="collapse" data-bs-target="#desc-<?= $task['id'] ?>">
                                    <?php 
                                        $badgeClass = 'bg-secondary';
                                        if ($task['status'] === 'concluida') $badgeClass = 'bg-success';
                                        if ($task['status'] === 'em_andamento') $badgeClass = 'bg-warning text-dark';
                                        
                                        $statusFormatado = str_replace('_', ' ', $task['status']);
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= mb_strtoupper($statusFormatado) ?>
                                    </span>
                                </td>
                                
                                <td data-bs-toggle="collapse" data-bs-target="#desc-<?= $task['id'] ?>">
                                    <?= date('d/m/Y H:i', strtotime($task['created_at'])) ?>
                                </td>
                                
                                <!-- Esta coluna NÃO tem o collapse, então os botões funcionam normalmente -->
                                <td class="text-center">
                                    <a href="<?= base_url('/edit/' . $task['id']) ?>" class="btn btn-sm btn-outline-primary">
                                       Editar
                                    </a>
                                    
                                    <a href="<?= base_url('/delete/' . $task['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                                       Excluir
                                    </a>
                                </td>
                            </tr>
                            
                            <!-- Linha oculta com a descrição (Expansível) -->
                            <tr>
                                <td colspan="5" class="p-0 border-0">
                                    <div class="collapse" id="desc-<?= $task['id'] ?>">
                                        <div class="p-4 bg-light border-bottom text-dark">
                                            <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.8rem;">Detalhes da Tarefa</h6>
                                            <p class="mb-0">
                                                <?= !empty($task['description']) ? nl2br(esc($task['description'])) : '<em>Nenhuma descrição fornecida para esta tarefa.</em>' ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center p-4">Nenhuma tarefa encontrada. Comece cadastrando uma!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->endSection() ?>