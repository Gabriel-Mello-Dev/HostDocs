<?php
session_start();
require_once '../conexao/config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Gera token CSRF simples
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Busca apenas os arquivos do usuário logado
$sql = "SELECT * FROM arquivos WHERE usuario_id = :usuario_id ORDER BY data_upload DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':usuario_id' => $_SESSION['user_id']]);
$arquivos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arquivos Enviados</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
  
  <div class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-slate-900">Arquivos Enviados</h1>
        <p class="text-slate-600 mt-1">Total: <?= count($arquivos) ?> arquivo(s)</p>
      </div>
      <a href="./uploadArquivos.php" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
        Novo Upload
      </a>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
      <div class="mb-6 p-4 rounded-lg <?= $_SESSION['flash']['type'] === 'ok' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
        <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
      </div>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (empty($arquivos)): ?>
      <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-slate-200">
        <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        <h3 class="mt-4 text-lg font-semibold text-slate-900">Nenhum arquivo enviado</h3>
        <p class="mt-2 text-slate-600">Faça o upload do seu primeiro arquivo.</p>
      </div>
    <?php else: ?>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($arquivos as $arquivo): 
          $extensao = strtolower(pathinfo($arquivo['nome_original'], PATHINFO_EXTENSION));
          $isImagem = in_array($extensao, ['png', 'jpg', 'jpeg']);
          $isPDF = $extensao === 'pdf';
          $isWord = in_array($extensao, ['doc', 'docx']);
        ?>
          <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden hover:shadow-lg transition">
            
            <!-- Preview -->
            <div class="aspect-video bg-slate-100 flex items-center justify-center overflow-hidden">
              <?php if ($isImagem): ?>
                <img src="<?= htmlspecialchars($arquivo['caminho']) ?>" alt="<?= htmlspecialchars($arquivo['nome_original']) ?>" class="w-full h-full object-cover">
              <?php elseif ($isPDF): ?>
                <svg class="h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.5,15.5C15.5,17.38 14.09,18.5 12.25,18.5C11.28,18.5 10.45,18.25 9.5,17.66V15.91C10.05,16.36 11.03,16.75 12,16.75C12.95,16.75 13.5,16.32 13.5,15.63C13.5,14.85 12.5,14.5 11.5,14.13C10.3,13.68 9,13.13 9,11.38C9,9.88 10.13,8.75 12,8.75C12.95,8.75 13.95,9.06 14.5,9.44V11.19C14.04,10.91 13.13,10.5 12.13,10.5C11.28,10.5 11,10.97 11,11.38C11,12.16 12,12.5 13,12.88C14.2,13.33 15.5,13.88 15.5,15.5M13,9V3.5L18.5,9H13Z"/>
                </svg>
              <?php elseif ($isWord): ?>
                <svg class="h-16 w-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.2,20H13.8L12,13.2L10.2,20H8.8L6.6,11H8.1L9.5,17.8L11.3,11H12.6L14.4,17.8L15.8,11H17.3L15.2,20M13,9V3.5L18.5,9H13Z"/>
                </svg>
              <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="p-4">
              <h3 class="font-semibold text-slate-900 truncate" title="<?= htmlspecialchars($arquivo['nome_original']) ?>">
                <?= htmlspecialchars($arquivo['nome_original']) ?>
              </h3>
              <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                <span><?= number_format($arquivo['tamanho'] / 1024, 2) ?> KB</span>
                <span><?= date('d/m/Y H:i', strtotime($arquivo['data_upload'])) ?></span>
              </div>
              <div class="mt-3 grid grid-cols-3 gap-2">
                <a href="<?= htmlspecialchars($arquivo['caminho']) ?>" target="_blank" class="text-center bg-blue-600 text-white text-sm font-medium py-2 rounded-lg hover:bg-blue-500 transition">
                  Abrir
                </a>
                <a href="<?= htmlspecialchars($arquivo['caminho']) ?>" download class="text-center bg-slate-100 text-slate-700 text-sm font-medium py-2 rounded-lg hover:bg-slate-200 transition border border-slate-300">
                  Baixar
                </a>
                <form action="../functions/excluir.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este arquivo?')" class="m-0">
                  <input type="hidden" name="id" value="<?= (int)$arquivo['id'] ?>">
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <button type="submit" class="w-full text-center bg-red-600 text-white text-sm font-medium py-2 rounded-lg hover:bg-red-500 transition">
                    Excluir
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>