(() => {
  const share = document.querySelector('#share-story');
  share?.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(window.location.href);
      share.textContent = 'Link copied';
    } catch {
      window.prompt('Copy this story link', window.location.href);
    }
  });
  document.querySelector('#print-story')?.addEventListener('click', () => window.print());
})();
