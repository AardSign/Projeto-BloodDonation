self.addEventListener("install", event => {
  event.waitUntil(
    caches.open("app-cache").then(cache => {
      return cache.addAll([
        "/",
         "/icons/icon-192.png",
        "/icons/icon-512.png",
        "/build/assets/app-ab9fb1ca.js", // use o nome correto gerado no build
        "/build/assets/app-00d5b011.css"
      ]);
    })
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
