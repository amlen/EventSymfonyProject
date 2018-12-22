import { Component, OnInit } from '@angular/core';
import { Category } from 'src/app/classes/category';
import { Router } from '@angular/router';
import { EventService } from 'src/app/services/event.service';
import { CategoryService } from 'src/app/services/category.service';
import { HttpClient } from '@angular/common/http';
import { Event } from 'src/app/classes/event';
import { ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-add-event',
  templateUrl: './add-event.component.html',
  styleUrls: ['./add-event.component.css']
})
export class AddEventComponent implements OnInit {

  event: Event;
  categories: Category[];
 // angForm: FormGroup;
  constructor(private router: Router,
              private eventService: EventService,
              private categoryService: CategoryService,
              private http: HttpClient,
             /* private fb: FormBuilder*/ ) {
    this.event = new Event();
   // this.createForm();
  }

  ngOnInit() {
    this.getCategories();
  }

  getCategories() {
    this.categoryService.getCategories().subscribe(
      (data) => {
        this.categories = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  onSubmit() {
    // tslint:disable-next-line:prefer-const
    let event = {
      'name': this.event.name,
      'description': this.event.description,
      'date': this.event.date,
      'category': this.event.category.id
    };

    this.eventService.postEvent(event).subscribe(
      (data) => {
        if (data['valid'] === true) {
          alert('The event is well added');
          this.router.navigate(['/events']);
        } else {
           console.log('error');
          }
      }
    );
  }


}
