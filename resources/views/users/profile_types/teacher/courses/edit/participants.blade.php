@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
   <div class="col-lg-8 col-lg-offset-2 course_form">
		<p class="title_desc">Здесь отображаются заявки пользователей, которые хотят пройти обучение на вашем курсе. Вы можете принять, отказать или провести пробное занятие с учеником. Если ваши занятия платные — договоритесь с учеником об удобном способе оплаты для вас обоих и приступайте к обучению. В ближайшем будущем мы реализуем возможность онлайн-оплаты.</p>
		<h4 class="sub_title_page">Описание</h4>
		<p class="title_desc">Если вы готовы провести пробное занятие — нажмите на соответствующую кнопку возле участника. После этого занятие будет активировано и автоматически отобразится дата первой лекции.
		После завершения занятия кнопка «Пробное занятие» будет неактивна. В дальнейшем вы должны будете принять решение — принимать ученика в качестве участника курса или отказать ему в обучении, используя соответствующие кнопки.</p>
      <div class="row" style="margin-bottom: 40px;"> 
         @if(count($course->userRequests) > 0)
            @foreach($course->userRequests as $user)
               <div class="col-md-12 userRequest">
                  <div class="row">
                     <div class="col-md-9 request__info_inner">
                        <div class="row">
                           <div class="col-md-4 request__user_name_img">
                              <div class="profile__img" 
                                   style="background-image: url(/public/uploads/users/{{ $user->avatar ? $user->avatar : $user->image }}{{'?v=' . time()}});">
                              </div>
                              <strong>
                                 {{ $user['name'] }}
                              </strong>
                           </div>
                           <div class="col-md-4 request__user_info">
                              <div>
                                 <strong>ТЕЛЕФОН</strong>
                                 <a class="request__phone" href="tel:{{ $user['phone'] }}">{{ $user['phone'] }}</a>
                              </div>
                              <br> 
                              <div>
                                 <strong>E-MAIL</strong>
                                 <a class="request__email" href="mailto:{{ $user['email'] }}">{{ $user['email'] }}</a>
                              </div>
                           </div>
                           <div class="col-md-4">
                              
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 request__actions">
                        <div class="request__top">
                           @if(!$user->pivot->confirm)
                              <a href="{{ route(userRoute('confirm_participant'), ['course' => $course->id, 'user' => $user->id]) }}" 
                                 class="request_btn conf confirm__item">
                                 Принять
                              </a>

                              <a href="{{ route(userRoute('decline_participants'), ['course' => $course->id, 'user' => $user->id]) }}" class="request_btn decline confirm__item">Отказать</a>
                           @else
                              <button type="button" class="request_btn rc_confirmed">Подтвержен</button>
                           @endif 
                        </div>
                        @if(!$user->pivot->confirm)
                           <a href="{{ route(userRoute('course_participants'), ['id' => $course->id]) }}" class="request_btn test_course confirm__item">
                              ПРОБНОЕ ЗАНЯТИЕ
                           </a>
                        @endif 
                     </div> 
                  </div>
               </div>
            @endforeach
            <style>

               .request_btn{
                  width: 100%; 
                  color: #fff;
                  text-transform: uppercase;
                  border-radius: 20px;
                  padding:5px 0;
                  border:none;
                  outline: none;
                  font-size: 13px;
                  margin-bottom: 10px;
                  text-align: center;
                  display: block;
                  text-decoration: none;
               }

               .request_btn:hover{
                  text-decoration: none;
                  color: #fff;
               }

               .request_btn.conf{
                  background-color: rgba(153, 153, 204, 1);
               }

               .request_btn.decline{
                  background-color: #fff;
                  color: #333;
               }

               .request_btn.rc_confirmed{
                  background: green;
                  cursor: default;
               }

               .test_course{
                  background-color: rgba(153, 204, 255, 1);
                  color: #333;
                  width: 85%;
                  position: absolute;
                  bottom: 0px;
               }

               .userRequest{
                  margin-bottom: 15px;
               }
               
               .userRequest > .row, .request__info_inner > .row{
                  justify-content: space-between;
                  align-items: stretch;
                  display: flex;
               }

               .request__user_info{
                  border-right: 1px solid #98cdfe;
               }

               .request__user_info strong{
                  font-size: 11px;
                  display: block;
               }

               .request__phone{
                  font-size: 16px;
                  font-weight: bold;
                  text-decoration: none;
                  color: #333;
               }

               .request__email{
                  font-size: 13px;
               }

               .request__info_inner{
                  -webkit-box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.349019607843137);
                   box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.349019607843137); 
                   padding: 15px;
                   z-index: 99;
               }

               .request__actions{
                  position: relative;
                  background-color: rgba(215, 215, 215, 1);
                  -webkit-box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.349019607843137);
                  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.349019607843137);
                  padding: 15px;
               }

               .request__user_name_img{
                  text-align: center;
                  border-right: 1px solid #98cdfe;
               }

               .request__user_name_img .profile__img{
                  padding-top: 0;
                  width: 100px;
                  height: 100px; 
               }

               .request__user_name_img strong{
                  font-size: 16px;
               }
            </style>
         @else
            <div class="col-md-12">
               <div class="no__data"> 
                  <h5>Нет участников курса</h5>
               </div>
            </div>
         @endif
      </div>    
    </div> 
@stop