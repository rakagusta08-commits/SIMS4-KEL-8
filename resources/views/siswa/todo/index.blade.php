@extends('layouts.master')

@section('title', 'To-Do List | SIM SEKOLAH')

@section('content')
<style>
    :root {
        --primary: #6366f1;
        --accent: #8b5cf6;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    .todo-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        border-radius: 30px;
        padding: 40px;
        margin-bottom: 40px;
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.2);
    }

    .stats-boxes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 15px;
        text-align: center;
    }

    .stat-box h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-box p {
        font-size: 0.9rem;
        margin: 5px 0 0 0;
        opacity: 0.9;
    }

    .content-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        padding: 0;
    }

    @media (max-width: 1200px) {
        .content-container {
            grid-template-columns: 1fr;
        }
    }

    .section-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .section-header {
        background: linear-gradient(135deg, #f8f9ff, #f5f3ff);
        padding: 25px;
        border-bottom: 3px solid var(--primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-header h3 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
    }

    .section-header .icon {
        font-size: 2rem;
        margin-right: 10px;
    }

    .todo-item {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        gap: 15px;
        align-items: flex-start;
        transition: all 0.3s ease;
        background: white;
    }

    .todo-item:hover {
        background: #f9fafb;
        padding-left: 25px;
    }

    .todo-item.completed {
        opacity: 0.7;
        background: #f0fdf4;
    }

    .todo-checkbox {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid var(--primary);
        cursor: pointer;
        flex-shrink: 0;
        margin-top: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .todo-item.completed .todo-checkbox {
        background: var(--success);
        border-color: var(--success);
        color: white;
    }

    .todo-content {
        flex-grow: 1;
        min-width: 0;
    }

    .todo-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
        margin: 0 0 5px 0;
        text-decoration: none;
        word-break: break-word;
    }

    .todo-item.completed .todo-title {
        text-decoration: line-through;
        color: #64748b;
    }

    .todo-meta {
        display: flex;
        gap: 15px;
        margin-top: 8px;
        flex-wrap: wrap;
        font-size: 0.85rem;
        color: #64748b;
    }

    .priority-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .priority-rendah {
        background: #dbeafe;
        color: #0c4a6e;
    }

    .priority-sedang {
        background: #fef3c7;
        color: #92400e;
    }

    .priority-tinggi {
        background: #fee2e2;
        color: #991b1b;
    }

    .deadline-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        background: #f0f4ff;
        border-radius: 8px;
        color: var(--primary);
        font-weight: 600;
    }

    .deadline-tag.overdue {
        background: #fee2e2;
        color: var(--danger);
    }

    .todo-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-edit {
        background: #eff6ff;
        color: #0284c7;
    }

    .btn-edit:hover {
        background: #0284c7;
        color: white;
    }

    .btn-delete {
        background: #fef2f2;
        color: var(--danger);
    }

    .btn-delete:hover {
        background: var(--danger);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state img {
        width: 80px;
        opacity: 0.5;
        margin-bottom: 15px;
    }

    .empty-state p {
        color: #64748b;
        font-size: 1rem;
    }

    .btn-add-todo {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add-todo:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        color: white;
    }

    .btn-clear-completed {
        background: #f3f4f6;
        color: #6b7280;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-clear-completed:hover {
        background: #e5e7eb;
    }
</style>

<div style="padding: 30px;">
    {{-- Header --}}
    <div class="todo-header">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
            <div>
                <h1 class="fw-bold mb-1">📋 To-Do List Saya</h1>
                <p class="mb-0 opacity-75">Kelola tugas dan deadline dengan mudah</p>
            </div>
            <a href="{{ route('siswa.todo.create') }}" class="btn-add-todo">
                <i class="fas fa-plus"></i> Tambah Tugas
            </a>
        </div>

        <div class="stats-boxes">
            <div class="stat-box">
                <h3>{{ $todos_pending->count() }}</h3>
                <p>Tugas Pending</p>
            </div>
            <div class="stat-box">
                <h3>{{ $todos_completed->count() }}</h3>
                <p>Tugas Selesai</p>
            </div>
            <div class="stat-box">
                <h3>
                    @php
                        $urgent = $todos_pending->where('prioritas', 'Tinggi')->count();
                    @endphp
                    {{ $urgent }}
                </h3>
                <p>Urgen</p>
            </div>
        </div>
    </div>

    <div class="content-container">
        {{-- Tugas Pending --}}
        <div class="section-card">
            <div class="section-header">
                <div style="display: flex; align-items: center;">
                    <span class="icon">🔄</span>
                    <h3>Sedang Berjalan ({{ $todos_pending->count() }})</h3>
                </div>
            </div>

            <div style="max-height: 600px; overflow-y: auto;">
                @forelse($todos_pending as $todo)
                    @php
                        $isOverdue = $todo->deadline && \Carbon\Carbon::parse($todo->deadline)->isPast();
                    @endphp
                    <div class="todo-item" data-todo-id="{{ $todo->id }}">
                        <div class="todo-checkbox" onclick="completeTask({{ $todo->id }})">
                            <i class="fas fa-check" style="display: none;"></i>
                        </div>

                        <div class="todo-content">
                            <p class="todo-title">{{ $todo->judul_tugas }}</p>
                            
                            @if($todo->deskripsi)
                                <p style="font-size: 0.9rem; color: #64748b; margin: 5px 0;">
                                    {{ Str::limit($todo->deskripsi, 100) }}
                                </p>
                            @endif

                            <div class="todo-meta">
                                <span class="priority-badge priority-{{ strtolower($todo->prioritas) }}">
                                    ⭐ {{ $todo->prioritas }}
                                </span>
                                
                                @if($todo->deadline)
                                    <span class="deadline-tag {{ $isOverdue ? 'overdue' : '' }}">
                                        <i class="fas fa-calendar"></i>
                                        {{ $isOverdue ? '⚠️ ' : '' }}{{ \Carbon\Carbon::parse($todo->deadline)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="todo-actions">
                            <a href="{{ route('siswa.todo.edit', $todo->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('siswa.todo.destroy', $todo->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox fa-3x opacity-25 mb-3 d-block"></i>
                        <p>Tidak ada tugas pending</p>
                        <small style="color: #94a3b8;">Tambahkan tugas baru atau selesaikan tugas yang ada</small>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Tugas Selesai --}}
        <div class="section-card">
            <div class="section-header">
                <div style="display: flex; align-items: center;">
                    <span class="icon">✅</span>
                    <h3>Sudah Selesai ({{ $todos_completed->count() }})</h3>
                </div>
                @if($todos_completed->count() > 0)
                    <form action="{{ route('siswa.todo.clearCompleted') }}" method="POST" onsubmit="return confirm('Hapus semua tugas yang sudah selesai?')" style="display: inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-clear-completed">
                            <i class="fas fa-broom me-1"></i>Bersihkan
                        </button>
                    </form>
                @endif
            </div>

            <div style="max-height: 600px; overflow-y: auto;">
                @forelse($todos_completed as $todo)
                    <div class="todo-item completed" data-todo-id="{{ $todo->id }}">
                        <div class="todo-checkbox" onclick="uncompleteTask({{ $todo->id }})" style="background: var(--success); border-color: var(--success);">
                            <i class="fas fa-check" style="color: white;"></i>
                        </div>

                        <div class="todo-content">
                            <p class="todo-title">{{ $todo->judul_tugas }}</p>
                            
                            <div class="todo-meta">
                                <span class="priority-badge priority-{{ strtolower($todo->prioritas) }}">
                                    ⭐ {{ $todo->prioritas }}
                                </span>
                                
                                @if($todo->selesai_pada)
                                    <span style="color: var(--success); font-weight: 600;">
                                        ✓ Selesai: {{ $todo->selesai_pada->translatedFormat('d M Y H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="todo-actions">
                            <form action="{{ route('siswa.todo.destroy', $todo->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-star fa-3x opacity-25 mb-3 d-block"></i>
                        <p>Belum ada tugas yang selesai</p>
                        <small style="color: #94a3b8;">Selesaikan tugas dari kolom sebelah untuk melihatnya di sini</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    function completeTask(todoId) {
        fetch(`/siswa/todo/${todoId}/complete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function uncompleteTask(todoId) {
        fetch(`/siswa/todo/${todoId}/uncomplete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endsection
