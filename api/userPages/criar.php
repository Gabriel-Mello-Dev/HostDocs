<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="https://ih1.redbubble.net/image.2354162750.2051/pp,504x498-pad,600x600,f8f8f8.jpg" type="image/x-icon">
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <div class="bg-white border border-slate-200 rounded-2xl shadow p-6">
      <h1 class="text-2xl font-semibold text-slate-900 text-center">Cadastro</h1>
      <p class="text-slate-500 text-center text-sm mt-1">Crie sua conta para continuar</p>

      <?php if (!empty($_SESSION['flash'])): ?>
        <div class="mt-4 p-3 rounded border <?= $_SESSION['flash']['type']==='ok' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-red-50 border-red-200 text-red-700' ?>">
          <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
      <?php endif; ?>

      <form method="POST" action="cadastrar_user.php" class="mt-6 space-y-4" onsubmit="return validarFormulario()">
        <div>
          <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome</label>
          <input type="text" id="nome" name="nome" required
                 class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Seu nome completo" />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
          <input type="email" id="email" name="email" required
                 class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="seu@email.com" />
        </div>

        <div>
          <label for="senha" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
          <input type="password" id="senha" name="senha" minlength="6" required
                 class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Mínimo 6 caracteres" />
        </div>

        <div>
          <label for="confirmar_senha" class="block text-sm font-medium text-slate-700 mb-1">Confirmar senha</label>
          <input type="password" id="confirmar_senha" name="confirmar_senha" minlength="6" required
                 class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Repita a senha" />
        </div>

        <button type="submit"
                class="w-full rounded-lg bg-blue-600 text-white font-medium py-2.5 hover:bg-blue-500 transition">
          Cadastrar
        </button>
      </form>

      <div class="text-center mt-4">
        <a href="../index.php" class="text-sm text-blue-600 hover:underline">Já tem conta? Faça login</a>
      </div>
    </div>
  </div>

  <script>
    function validarFormulario() {
      const senha = document.getElementById('senha').value;
      const confirmar = document.getElementById('confirmar_senha').value;
      if (senha.length < 6) { alert('A senha deve ter pelo menos 6 caracteres.'); return false; }
      if (senha !== confirmar) { alert('As senhas não coincidem.'); return false; }
      return true;
    }
  </script>
</body>
</html>