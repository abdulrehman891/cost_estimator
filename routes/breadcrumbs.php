<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Management', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Users', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('user-management.permissions.index'));
});


// Home > Dashboard > products > List
Breadcrumbs::for('products.list', function (BreadcrumbTrail $trail) {
//    $trail->parent('product.list');
    $trail->push('Product List', route('product.list'));
});

// Home > Dashboard > product-price-history > List
Breadcrumbs::for('product-price-history.list', function (BreadcrumbTrail $trail) {
        $trail->push('Product Price History List', route('product-price-history.list'));
    });

// Home > Dashboard > project > List
Breadcrumbs::for('project.list', function (BreadcrumbTrail $trail) {
//    $trail->parent('product.list');
    $trail->push('Project List', route('project.list'));
});


// Home > Dashboard > sub-category > List
Breadcrumbs::for('sub-category.list', function (BreadcrumbTrail $trail) {
//    $trail->parent('product.list');
    $trail->push('Sub-Category List', route('sub-category.list'));
});

// Home > Dashboard > category > List
Breadcrumbs::for('category.list', function (BreadcrumbTrail $trail) {
//    $trail->parent('product.list');
    $trail->push('Category List', route('category.list'));
});


// Home > Dashboard > Quotations > List
Breadcrumbs::for('quotation.list', function (BreadcrumbTrail $trail) {
//    $trail->parent('product.list');
    $trail->push('Quotation List', route('quotation.list'));
});
