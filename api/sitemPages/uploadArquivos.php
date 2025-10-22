<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload de Arquivos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
  
  <div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-200">
      <h1 class="text-3xl font-bold text-slate-900 mb-2">Upload de Arquivos</h1>
      <p class="text-slate-600 mb-6">Envie imagens (PNG/JPG) ou documentos (PDF/Word)</p>

      <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="mb-6 p-4 rounded-lg <?= $_SESSION['tipo'] === 'sucesso' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
          <?= htmlspecialchars($_SESSION['mensagem']) ?>
        </div>
        <?php unset($_SESSION['mensagem'], $_SESSION['tipo']); ?>
      <?php endif; ?>

      <form action="../functions/upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        
        <div>
          <label for="arquivo" class="block text-sm font-medium text-slate-700 mb-2">
            Selecione o arquivo
          </label>
          <input 
            type="file" 
            name="arquivo" 
            id="arquivo" 
            accept=".png,.jpg,.jpeg,.pdf,.doc,.docx"
            required
            class="block w-full text-sm text-slate-500
              file:mr-4 file:py-3 file:px-6
              file:rounded-lg file:border-0
              file:text-sm file:font-semibold
              file:bg-blue-600 file:text-white
              hover:file:bg-blue-500
              file:cursor-pointer cursor-pointer
              border border-slate-300 rounded-lg"
          />
          <p class="mt-2 text-xs text-slate-500">Formatos aceitos: PNG, JPG, PDF, DOC, DOCX (máx. 5MB)</p>
        </div>

        <div>
          <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">
            Descrição (opcional)
          </label>
          <textarea 
            name="descricao" 
            id="descricao" 
            rows="3"
            placeholder="Adicione uma descrição..."
            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
          ></textarea>
        </div>

        <div class="flex gap-3">
          <button 
            type="submit"
            class="flex-1 bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-500 transition shadow-lg shadow-blue-600/30"
          >
            Enviar Arquivo
          </button>
          <a 
            href="listar.php"
            class="flex-1 text-center bg-slate-100 text-slate-700 font-semibold py-3 px-6 rounded-lg hover:bg-slate-200 transition border border-slate-300"
          >
            Ver Arquivos
          </a>
        </div>
      </form>



<a href="../userPages/logout.php">Sair</a>

    </div>

    <!-- Preview do arquivo selecionado -->
    <div id="preview" class="mt-6 hidden bg-white rounded-2xl shadow-lg p-6 border border-slate-200">
      <h3 class="font-semibold text-slate-900 mb-3">Preview</h3>
      <div id="previewContent"></div>
    </div>
  </div>

  <script>
    const input = document.getElementById('arquivo');
    const preview = document.getElementById('preview');
    const previewContent = document.getElementById('previewContent');

    input.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (!file) {
        preview.classList.add('hidden');
        return;
      }

      preview.classList.remove('hidden');
      previewContent.innerHTML = '';

      // Info do arquivo
      const info = document.createElement('div');
      info.className = 'text-sm text-slate-600 mb-3';
      info.innerHTML = `
        <p><strong>Nome:</strong> ${file.name}</p>
        <p><strong>Tamanho:</strong> ${(file.size / 1024).toFixed(2)} KB</p>
        <p><strong>Tipo:</strong> ${file.type || 'Desconhecido'}</p>
      `;
      previewContent.appendChild(info);

      // Preview de imagem
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'max-w-full h-auto rounded-lg border border-slate-200';
          previewContent.appendChild(img);
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>
</html>