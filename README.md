
# Economiza — Gerenciador Financeiro Pessoal

Resumo
-------
Economiza é uma aplicação web simples para controle financeiro pessoal: registrar receitas, despesas, categorias, visualizar saldos e gráficos mensais/anuais. Projeto em Laravel pensado para uso local (XAMPP) e aprendizado.

Funcionalidades principais
--------------------------
- Autenticação (registro/login/logout).
- Cadastro de receitas (incomes) e despesas (expenses).
- Categorias de despesas por usuário.
- Visualização de transações paginadas.
- Filtros por mês e ano.
- Relatórios rápidos: totais de receitas, despesas e saldo.
- Gráficos de evolução mensal e anual.

Tecnologias
-----------
- PHP 8.x
- Laravel (6/7/8/9 — ajuste conforme composer.json do projeto)
- MySQL (via XAMPP)
- Blade (templates)
- Chart.js (gráficos)
- Tailwind CSS / CSS custom (conforme views)
- Composer (dependências)
- Git (controle de versão)

Pré‑requisitos
--------------
- Windows (desenvolvimento local)
- XAMPP (Apache + MySQL)
- PHP instalado (versão compatível com Laravel do projeto)
- Composer
- Git (opcional)

Instalação (rápido)
-------------------
1. Clone o repositório:
   git clone <repo-url> c:\xampp\htdocs\projetos\economiza

2. Entre na pasta e instale dependências:
   composer install

3. Copie o arquivo .env e gere a chave da aplicação:
   copy .env.example .env
   php artisan key:generate

4. Configure o banco em .env (exemplo MySQL local XAMPP):
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=economiza
   DB_USERNAME=root
   DB_PASSWORD=

5. Crie o banco no phpMyAdmin (nome conforme .env) e rode migrations:
   php artisan migrate
   (Se houver seeders: php artisan db:seed)

6. Inicie o servidor local (opcional):
   php artisan serve
   Ou acesse via http://localhost/projetos/economiza se usando Apache do XAMPP.

Uso
---
- Acesse a aplicação e registre um usuário.
- No painel "Minhas Transações" você pode:
  - Adicionar receita ou despesa (certifique‑se de enviar valores numéricos).
  - Criar/editar categorias no perfil.
  - Filtrar transações por mês/ano.
  - Visualizar totais e gráficos.

Observações importantes
-----------------------
- Campos numéricos (amount/value) devem receber valores numéricos. Erros de formato (ex.: inserir texto no campo amount) causam falhas no banco.
- Modelos Eloquent precisam expor os campos preenchíveis ($fillable) para usar create(). Verifique app/Models para ajustar se necessário (ex.: ExpenseCategory: ['name','user_id']).
- Nomes de colunas de referência de usuário seguem o padrão do projeto: usar user_id consistentemente. Ajuste código se estiver usando id_user.

Comandos úteis
--------------
- Executar migrations: php artisan migrate
- Rodar seeders: php artisan db:seed
- Limpar cache config/route/view: php artisan config:clear && php artisan route:clear && php artisan view:clear
- Testes (se houver): php artisan test

Estrutura relevante (resumo)
----------------------------
- app/Http/Controllers — controladores (HomeController, ProfileController, LoginController, etc.)
- app/Models — modelos Eloquent (User, Expense, Income, ExpenseCategory, Transaction, ...)
- resources/views — views Blade
- database/migrations — migrations das tabelas
- public/ — assets públicos (JS/CSS)

Contribuição
-----------
Pull requests são bem‑vindos. Abra issues para bugs ou sugestões. Mantenha um padrão claro de commits.

Licença
-------
MIT

// ...existing code...<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
