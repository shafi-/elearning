## About E-Learning

E-learning is a web-based solutions for learners. It offers multiple courses. Each course has multiple lessons. User can select lesson from a course and assess thyself through a MCQ based exam.

## Get Started:
  - clone the project [ you may want to fork before, if you like to extend it's functionality ]
  - run `composer install` [ asuming you have composer installed ]
  - run `php artisan migrate --seed`
    This will seed 1 admin (email: admin@elearning.com, password: abcd1234), 5 dummy courses, 5~10 lessons to each courses with 10 mcqs per lesson.
  - run `php artisan serve`
  - open `http://localhost:8000`

## Contributing

Thank you for considering contributing. Fork the project, made changes or extend functionality, commit and create a pull request. Please follow PSR otherwise your contribution may not be considered.

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to Md Abdullahil Shafi via [shafi.cse.buet@gmail.com](mailto:shafi.cse.buet@gmail.com). All security vulnerabilities will be promptly addressed.

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
