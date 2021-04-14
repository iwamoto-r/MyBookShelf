window.onload = async function() {

  console.log(author);
  // 検索する
  var search = async () => {
    // 入力された値でを本を検索
    var items = await searchBooks(author);

    // html に変換して表示用 DOM に代入
    var texts = items.map(item => {
      return `
      <div class='media'>
        <div class='media-left'>
          <a href='${item.link}', target='_blank'>
          <img class='media-object' src='${item.image}' />
        </div>
        <div class='media-body'>
          <h3 class='media-heading'>${item.title}</h3>
          <p class='text-dark'>${item.description}</p>
        </div>
      </div>`;
    });
    $results.innerHTML = texts.join('');
  };

  // 初期値設定
  $q.value = author;
  search();
};

// 本を検索して結果を返す
var searchBooks = async (query) => {
  // Google Books APIs のエンドポイント
  var endpoint = 'https://www.googleapis.com/books/v1';

  // 検索 API を叩く
  var res = await fetch(`${endpoint}/volumes?q=${author}`);
  console.log(res);

  // JSON に変換
  var data = await res.json();
  console.log(data);


  // 必要なものだけ抜き出してわかりやすいフォーマットに変更する
  var items = data.items.map(item => {
    var vi = item.volumeInfo;
    return {
      title: vi.title,
      description: vi.description,
      link: vi.infoLink,
      image: vi.imageLinks ? vi.imageLinks.smallThumbnail : '',
    };
  });

  return items;
};
