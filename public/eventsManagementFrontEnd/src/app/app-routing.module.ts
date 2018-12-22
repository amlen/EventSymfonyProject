import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CategoryComponent } from './components/category/category.component';
import { AddCategoryComponent } from './components/add-category/add-category.component';
import { UpdateCategoryComponent } from './components/update-category/update-category.component';
import { DisplayEventsComponent } from './components/event/display-events/display-events.component';
import { UpdateEventComponent } from './components/event/update-event/update-event.component';
import { AddEventComponent } from './components/event/add-event/add-event.component';

const routes: Routes = [
  { path: 'categories', component: CategoryComponent },
  { path: 'addCategory', component: AddCategoryComponent },
  { path: 'updateCategory/:id', component: UpdateCategoryComponent },
  { path: 'events', component: DisplayEventsComponent },
  { path: 'addevent', component: AddEventComponent },
  { path: 'updateEvent/:id', component: UpdateEventComponent },
  { path: '', redirectTo: '/events', pathMatch: 'full' },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
