const translations = {
    ru: {
        home: "Главная",
        programEPS: "Программа EPS-TOPIK",
        about: "О Нас",
        news: "Новости",
        contact: "Контакты",
        apply: "Заявка",
        baner: "Профессиональное обучение для работы в Южной Корее!",
        details: "Подробнее",
        primutext: "ПРЕИМУЩЕСТВА ОБУЧЕНИЯ В НАШЕМ ЦЕНТРЕ"
    },
    tj: {
        home: "Асосӣ",
        programEPS: "Барномаи EPS-TOPIK",
        about: "Дар бораи мо",
        news: "Хабарҳо",
        contact: "Тамос",
        apply: "Ариза",
        baner: "Омӯзиши касбӣ барои кор дар Кореяи Ҷанубӣ!",
        details: "Муфассал",
        primutext: "БАРТАРИЯХОИ ТАЪЛИМ ДАР МАРКАЗИ МО"
    }
};

function changeLanguage(lang) {
    document.querySelectorAll("[key]").forEach(element => {
        const key = element.getAttribute("key");
        element.textContent = translations[lang][key];
    });

    localStorage.setItem("selectedLang", lang);
}

document.addEventListener("DOMContentLoaded", () => {
    const savedLang = localStorage.getItem("selectedLang") || "ru";
    changeLanguage(savedLang);
});
