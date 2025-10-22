<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center p-4">
  <div class="w-full max-w-sm">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
      <!-- Header -->
      <div class="px-6 pt-6 pb-4 text-center">
        <div class="mx-auto h-12 w-12 rounded-xl bg-blue-600/10 flex items-center justify-center">
          <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12a5 5 0 1 0-5-5 5.006 5.006 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 4.5V21h16v-2.5C20 16.17 16.33 14 12 14Z"/>
          </svg>
        </div>
        <h1 class="text-2xl font-semibold text-slate-900 mt-3">Bem-vindo(a)</h1>
        <p class="text-sm text-slate-500 mt-1">Acesse sua conta</p>
      </div>

      <!-- Alert (opcional: usar com flash de sessão) -->
      <?php if (!empty($_SESSION['erro_login'])): ?>
        <div class="mx-6 mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
          <?= htmlspecialchars($_SESSION['erro_login']) ?>
        </div>
        <?php unset($_SESSION['erro_login']); ?>
      <?php endif; ?>

      <!-- Form -->
      <form method="post" action="verificarUser.php" class="px-6 pb-6 space-y-4">
        <div>
          <label for="username" class="block text-sm font-medium text-slate-700">E-mail</label>
          <input
            type="email"
            id="username"
            name="username"
            required
            class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
            placeholder="voce@exemplo.com"
            autocomplete="email"
          />
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-slate-700">Senha</label>
            <a href="#" class="text-xs text-blue-600 hover:underline">Esqueceu a senha?</a>
          </div>
          <input
            type="password"
            id="password"
            name="password"
            required
            class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
            placeholder="Sua senha"
            autocomplete="current-password"
          />
        </div>

        <button
          type="submit"
          class="w-full rounded-lg bg-blue-600 py-2.5 text-white font-semibold shadow-lg shadow-blue-600/30 hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Entrar
        </button>

        <div class="text-center text-sm text-slate-600">
          Não tem conta?
          <a href="./userPages/criar.php" class="font-medium text-blue-600 hover:underline">Cadastre-se</a>
        </div>
      </form>
    </div>

    <!-- Rodapé simples -->
    <p class="mt-4 text-center text-xs text-slate-500">
      Protegido por medidas de segurança. Não compartilhe suas credenciais.
    </p>
  </div>
</body>
</html>