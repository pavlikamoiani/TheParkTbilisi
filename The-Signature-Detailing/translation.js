// Translation dictionary
const translations = {
	en: {
		'hero-title': 'DETAILING CENTER IN TBILISI - The Park.',
		'hero-desc': 'Professional car care and protection, with the best result and level of service: car polishing, ceramic coating, pasting in a protective film, car cleaning, paintless dent removal, interior restoration.',
		'book-now-btn': 'Book Now',
		'services-title': 'Our Services',
		'service-wash': 'Car Wash',
		'service-wash-desc': 'Thorough exterior and interior cleaning for a spotless finish.',
		'service-ppf': 'PPF Wrap',
		'service-ppf-desc': 'Paint Protection Film application to shield your car from scratches and chips.',
		'service-polish': 'Polishing',
		'service-polish-desc': 'Professional polishing to restore gloss and remove imperfections.',
		'service-ceramic': 'Ceramic Coating',
		'service-ceramic-desc': 'Advanced ceramic protection for long-lasting shine and durability.',
		'service-dry': 'Dry Cleaning',
		'service-dry-desc': 'Deep interior dry cleaning for seats, carpets, and surfaces.',
		'service-sound': 'Sound Proofing',
		'service-sound-desc': 'Reduce road noise and enhance comfort with professional sound proofing.',
		'service-door': 'Door Vacuum',
		'service-door-desc': 'Specialized vacuuming for door panels and hard-to-reach areas.',
		'work-title': 'Our Work',
		'work-subtitle': 'See some of our recent detailing projects',
		'showMoreBtn': 'Show More',
		'testimonials-title': 'What Our Customers Say',
		'testimonials-subtitle': "Don't just take our word for it - hear from our satisfied clients",
		'testimonial-1': 'The attention to detail was absolutely incredible. My 10-year-old car looks brand new again! The ceramic coating they applied has made maintenance so much easier.',
		'customer-1-name': 'Michael Thompson',
		'customer-1-car': 'Ford Explorer Owner',
		'testimonial-2': 'Professional service from start to finish. They took extra care with my car and the paint correction removed all the swirl and scratches marks I thought were permanent.',
		'customer-2-name': 'Sarah Johnson',
		'customer-2-car': 'BMW Series 5 Owner',
		'testimonial-3': "I've tried many detailing services over the years, but none compare to the quality and results I received here. The interior detailing transformed my car's cabin completely.",
		'customer-3-name': 'David Rodriguez',
		'customer-3-car': 'Mercedes GLC-300 Owner',
		'faq-title': 'Frequently Asked Questions',
		'faq-desc': 'Find answers of common questions about our services, process, and policies.',
		'faq-q1': 'What services do you offer?',
		'faq-a1': "We offer a comprehensive range of detailing services including paint correction, ceramic coating, paint protection film, interior detailing, and maintenance packages. Each service is tailored to your vehicle's specific needs to ensure optimal protection and appearance.",
		'faq-q2': 'How long does the detailing process take?',
		'faq-a2': "The duration depends on the service package and condition of your vehicle. A basic interior detail typically takes 3-4 hours, while a full paint correction and ceramic coating can take 2-3 days. We'll provide you with an accurate timeframe during your consultation.",
		'faq-q3': 'How much does a detailing service cost?',
		'faq-a3': "Pricing varies based on your vehicle's size, condition, and the specific services requested. Our packages start at $150 for basic detailing and go up to $1,500+ for comprehensive paint correction and ceramic coating treatments. Contact us for a personalized quote based on your needs.",
		'faq-q4': 'Do you offer warranties on your services?',
		'faq-a4': "Yes, we stand behind our work with industry-leading warranties. Our ceramic coatings come with a 2-5 year warranty depending on the product selected, and paint protection film includes a 10-year warranty against yellowing, cracking, and peeling. All warranties require proper maintenance as outlined in our care guide.",
		'faq-q5': 'What is ceramic coating and how does it work?',
		'faq-a5': "Ceramic coating is a liquid polymer applied to the exterior of a vehicle that chemically bonds with the factory paint, creating a layer of protection. It provides superior protection against UV rays, chemical stains, and minor scratches while creating a hydrophobic surface that repels water and makes cleaning easier.",
		'faq-q6': 'Do I need to make an appointment?',
		'faq-a6': "Yes, we operate by appointment only to ensure we can dedicate the proper time and attention to each vehicle. This allows us to schedule our work efficiently and provide you with the best possible service. You can book an appointment through our website or by calling our studio directly.",
		'faq-q7': 'What payment methods do you accept?',
		'faq-a7': "We accept all major credit cards (Visa, MasterCard, American Express, Discover), debit cards, cash, and digital payment methods like Apple Pay and Google Pay. For larger projects, we also offer financing options through our partner lenders.",
		'footer-contact-title': 'Contact',
		'footer-phone': '+995 596 502 222',
		'footer-hours-title': 'Hours',
		'footer-hours-desc': '<b>We are open every day:</b> 8:00 AM - 7:00 PM',
		'footer-location-title': 'Location'
	},
	ru: {
		'hero-title': 'ЦЕНТР ДЕТЕЙЛИНГА В ТБИЛИСИ - The Park.',
		'hero-desc': 'Профессиональный уход и защита автомобиля: полировка, керамическое покрытие, защитная пленка, химчистка, удаление вмятин без покраски, восстановление салона.',
		'book-now-btn': 'Записаться',
		'services-title': 'Наши услуги',
		'service-wash': 'Мойка автомобиля',
		'service-wash-desc': 'Тщательная очистка кузова и салона для идеальной чистоты.',
		'service-ppf': 'Защитная пленка (PPF)',
		'service-ppf-desc': 'Покрытие защитной пленкой для защиты от царапин и сколов.',
		'service-polish': 'Полировка',
		'service-polish-desc': 'Профессиональная полировка для блеска и устранения дефектов.',
		'service-ceramic': 'Керамическое покрытие',
		'service-ceramic-desc': 'Современная керамическая защита для долговечного блеска.',
		'service-dry': 'Химчистка',
		'service-dry-desc': 'Глубокая химчистка салона, сидений, ковров и поверхностей.',
		'service-sound': 'Шумоизоляция',
		'service-sound-desc': 'Уменьшение шума и повышение комфорта с помощью шумоизоляции.',
		'service-door': 'Пылесос дверей',
		'service-door-desc': 'Специализированная чистка дверных панелей и труднодоступных мест.',
		'work-title': 'Наши работы',
		'work-subtitle': 'Посмотрите наши недавние проекты детейлинга',
		'showMoreBtn': 'Показать ещё',
		'testimonials-title': 'Отзывы клиентов',
		'testimonials-subtitle': 'Посмотрите, что говорят наши довольные клиенты',
		'testimonial-1': 'Внимание к деталям просто потрясающее. Моей машине 10 лет, а она выглядит как новая! Керамическое покрытие значительно упростило уход.',
		'customer-1-name': 'Михаил Томпсон',
		'customer-1-car': 'Владелец Ford Explorer',
		'testimonial-2': 'Профессиональный сервис от начала до конца. Краска стала идеальной, все царапины и разводы исчезли.',
		'customer-2-name': 'Сара Джонсон',
		'customer-2-car': 'Владелец BMW 5 серии',
		'testimonial-3': 'Пробовал много сервисов, но такого качества и результата не встречал. Химчистка салона преобразила интерьер.',
		'customer-3-name': 'Давид Родригес',
		'customer-3-car': 'Владелец Mercedes GLC-300',
		'faq-title': 'Часто задаваемые вопросы',
		'faq-desc': 'Ответы на популярные вопросы о наших услугах, процессе и политике.',
		'faq-q1': 'Какие услуги вы предоставляете?',
		'faq-a1': 'Мы предлагаем полный спектр услуг: коррекция лакокрасочного покрытия, керамика, защитная пленка, химчистка салона и пакеты обслуживания. Каждый сервис подбирается индивидуально.',
		'faq-q2': 'Сколько времени занимает детейлинг?',
		'faq-a2': 'Время зависит от выбранного пакета и состояния авто. Базовая химчистка — 3-4 часа, полная коррекция и керамика — 2-3 дня. Точные сроки сообщим при консультации.',
		'faq-q3': 'Сколько стоит детейлинг?',
		'faq-a3': 'Стоимость зависит от размера, состояния авто и выбранных услуг. Базовый пакет — от $150, комплексная коррекция и керамика — от $1,500+. Свяжитесь с нами для индивидуального расчёта.',
		'faq-q4': 'Есть ли гарантия на услуги?',
		'faq-a4': 'Да, мы предоставляем гарантию: керамика — 2-5 лет, защитная пленка — 10 лет от пожелтения, трещин и отслаивания. Для сохранения гарантии требуется правильный уход.',
		'faq-q5': 'Что такое керамическое покрытие?',
		'faq-a5': 'Керамика — это жидкий полимер, который химически связывается с краской, создавая защитный слой. Защищает от УФ, химии, мелких царапин и облегчает мойку.',
		'faq-q6': 'Нужно ли записываться заранее?',
		'faq-a6': 'Да, мы работаем только по записи, чтобы уделить максимум внимания каждому авто. Записаться можно на сайте или по телефону.',
		'faq-q7': 'Какие способы оплаты принимаете?',
		'faq-a7': 'Принимаем все основные карты, наличные, Apple Pay, Google Pay. Для крупных проектов — рассрочка через партнёров.',
		'footer-contact-title': 'Контакты',
		'footer-phone': '+995 596 502 222',
		'footer-hours-title': 'Время работы',
		'footer-hours-desc': '<b>Работаем ყოველდღე:</b> 8:00 - 19:00',
		'footer-location-title': 'Адрес'
	},
	ge: {
		'hero-title': 'დეტეილინგ ცენტრი თბილისში - The Park.',
		'hero-desc': 'პროფესიონალური ავტომობილის მოვლა და დაცვა: პოლირება, კერამიკული საფარი, დამცავი ფირი, ქიმწმენდა, საღებავის გარეშე დეფექტების მოცილება, ინტერიერის აღდგენა.',
		'book-now-btn': 'დაჯავშნა',
		'services-title': 'ჩვენი სერვისები',
		'service-wash': 'ავტომობილის რეცხვა',
		'service-wash-desc': 'გარეგანი და შიდა საფუძვლიანი წმენდა იდეალური შედეგისთვის.',
		'service-ppf': 'დამცავი ფირი (PPF)',
		'service-ppf-desc': 'დამცავი ფირის წასმა ნაკაწრებისა და დაზიანებებისგან დასაცავად.',
		'service-polish': 'პოლირება',
		'service-polish-desc': 'პროფესიონალური პოლირება ბზინვარებისა და დეფექტების მოსაშორებლად.',
		'service-ceramic': 'კერამიკული საფარი',
		'service-ceramic-desc': 'ინოვაციური კერამიკული დაცვა ხანგრძლივი ბზინვარებისთვის.',
		'service-dry': 'ქიმწმენდა',
		'service-dry-desc': 'სიღრმისეული ქიმწმენდა სავარძლებისთვის, ხალიჩებისთვის და ზედაპირებისთვის.',
		'service-sound': 'ხმაურის იზოლაცია',
		'service-sound-desc': 'გზის ხმაურის შემცირება და კომფორტის გაზრდა.',
		'service-door': 'კარის მტვერსასრუტი',
		'service-door-desc': 'სპეციალური მტვერსასრუტი კარის პანელებისა და რთულად მისადგომი ადგილებისთვის.',
		'work-title': 'ჩვენი ნამუშევრები',
		'work-subtitle': 'იხილეთ ჩვენი ბოლო დეტეილინგ პროექტები',
		'showMoreBtn': 'მეტის ჩვენება',
		'testimonials-title': 'რას ამბობენ ჩვენი კლიენტები',
		'testimonials-subtitle': 'იხილეთ კმაყოფილი კლიენტების შეფასებები',
		'testimonial-1': 'დეტალებზე ყურადღება საოცარია. ჩემი 10 წლის მანქანა ახალივით გამოიყურება! კერამიკული საფარი ძალიან აადვილებს მოვლას.',
		'customer-1-name': 'მიხეილ თომპსონი',
		'customer-1-car': 'Ford Explorer-ის მფლობელი',
		'testimonial-2': 'პროფესიონალური მომსახურება თავიდან ბოლომდე. საღებავის კორექციამ ყველა ნაკაწრი და დეფექტი გააქრო.',
		'customer-2-name': 'სარა ჯონსონი',
		'customer-2-car': 'BMW 5 სერიის მფლობელი',
		'testimonial-3': 'ბევრ სერვისს ვცადე, მაგრამ ასეთი ხარისხი და შედეგი არსად მინახავს. ინტერიერის ქიმწმენდა სრულიად გარდაქმნა სალონი.',
		'customer-3-name': 'დავით როდრიგესი',
		'customer-3-car': 'Mercedes GLC-300-ის მფლობელი',
		'faq-title': 'ხშირად დასმული კითხვები',
		'faq-desc': 'იპოვეთ პასუხები ჩვენს სერვისებზე, პროცესსა და პოლიტიკაზე.',
		'faq-q1': 'რა სერვისებს სთავაზობთ?',
		'faq-a1': 'ვთავაზობთ დეტეილინგის სრულ სპექტრს: საღებავის კორექცია, კერამიკა, დამცავი ფირი, ინტერიერის ქიმწმენდა და მოვლის პაკეტები. თითოეული სერვისი მორგებულია თქვენი მანქანისთვის.',
		'faq-q2': 'რამდენი დრო სჭირდება დეტეილინგს?',
		'faq-a2': 'დრო დამოკიდებულია პაკეტსა და მანქანის მდგომარეობაზე. საბაზისო ქიმწმენდა — 3-4 საათი, სრული კორექცია და კერამიკა — 2-3 დღე. ზუსტ დროს შეგატყობინებთ კონსულტაციისას.',
		'faq-q3': 'რამდენია დეტეილინგის ღირებულება?',
		'faq-a3': 'ფასი დამოკიდებულია ზომაზე, მდგომარეობაზე და არჩეულ სერვისებზე. საბაზისო პაკეტი — $150-დან, სრული კორექცია და კერამიკა — $1,500+. დაგვიკავშირდით ინდივიდუალური შეთავაზებისთვის.',
		'faq-q4': 'გთავაზობთ თუ არა გარანტიას?',
		'faq-a4': 'დიახ, გვაქვს ინდუსტრიის ლიდერი გარანტიები: კერამიკა — 2-5 წელი, დამცავი ფირი — 10 წელი გაყვითლების, ბზარისა და აყრისგან. გარანტიისთვის საჭიროა სწორი მოვლა.',
		'faq-q5': 'რა არის კერამიკული საფარი?',
		'faq-a5': 'კერამიკა — ეს არის თხევადი პოლიმერი, რომელიც ქიმიურად ებმის საღებავს და ქმნის დამცავ ფენას. იცავს UV-სგან, ქიმიური ზემოქმედებისგან, ნაკაწრებისგან და აადვილებს წმენდას.',
		'faq-q6': 'საჭიროა თუ არა წინასწარი ჩაწერა?',
		'faq-a6': 'დიახ, ვმუშაობთ მხოლოდ ჩაწერით, რათა თითოეულ მანქანას მაქსიმალური ყურადღება მივაქციოთ. ჩაწერა შესაძლებელია ვებგვერდზე ან ტელეფონით.',
		'faq-q7': 'რა გადახდის მეთოდებს იღებთ?',
		'faq-a7': 'ვიღებთ ყველა ძირითად ბარათს, ნაღდ ფულს, Apple Pay-ს, Google Pay-ს. დიდი პროექტებისთვის — განვადება პარტნიორების მეშვეობით.',
		'footer-contact-title': 'კონტაქტი',
		'footer-phone': '+995 596 502 222',
		'footer-hours-title': 'სამუშაო საათები',
		'footer-hours-desc': '<b>ღია ვართ ყოველდღე:</b> 8:00 - 19:00',
		'footer-location-title': 'მდებარეობა'
	}
};

function setLanguage(lang) {
	for (const key in translations[lang]) {
		const el = document.getElementById(key);
		if (el) {
			if (key === 'footer-hours-desc') {
				el.innerHTML = translations[lang][key];
			} else {
				el.textContent = translations[lang][key];
			}
		}
	}
	// Highlight active language
	document.querySelectorAll('.lang').forEach(a => a.classList.remove('active-lang'));
	document.getElementById('lang-' + lang).classList.add('active-lang');
}

document.getElementById('lang-en').addEventListener('click', function (e) {
	e.preventDefault();
	setLanguage('en');
});
document.getElementById('lang-ru').addEventListener('click', function (e) {
	e.preventDefault();
	setLanguage('ru');
});
document.getElementById('lang-ge').addEventListener('click', function (e) {
	e.preventDefault();
	setLanguage('ge');
});

// Set default language
setLanguage('en');