@extends('layouts.app')
@section('title', 'Welcome - Xpreium Academy')
@section('content')
    <style>
        /* ==============================================
                LOADING SCREEN STYLES
                ============================================== */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .loading-screen.fade-out {
            opacity: 0;
            pointer-events: none;
        }
        .loading-container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
            filter: drop-shadow(0 25px 30px rgba(0, 0, 0, 0.5));
        }
        .loading-logo {
            width: 120px;
            height: 120px;
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            position: relative;
            animation: logoFloat 3s ease-in-out infinite;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), inset 0 0 20px rgba(255, 255, 255, 0.1);
        }
        .loading-logo::before {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            border: 2px solid var(--accent);
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: logoRing 2s linear infinite;
            opacity: 0.6;
        }
        .loading-logo i {
            font-size: 3rem;
            color: var(--accent);
            animation: logoIcon 2s ease-in-out infinite;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }
        .loading-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            opacity: 0;
            animation: slideInUp 1s ease-out 0.5s forwards;
            letter-spacing: -0.5px;
        }
        .loading-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            opacity: 0;
            animation: slideInUp 1s ease-out 0.7s forwards;
        }
        .loading-progress {
            width: 100%;
            height: 3px;
            background: var(--secondary-bg);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 2rem;
            opacity: 0;
            animation: slideInUp 1s ease-out 0.9s forwards;
            border: 1px solid var(--border-color);
            position: relative;
        }
        .loading-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--accent) 0%, var(--text-secondary) 100%);
            border-radius: 2px;
            animation: loadingProgress 3s ease-out 1s forwards;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            position: relative;
        }
        .loading-percent {
            position: absolute;
            right: 0;
            top: -20px;
            font-size: 0.75rem;
            color: var(--accent);
            font-weight: 700;
            opacity: 0;
            animation: slideInUp 1s ease-out 1.2s forwards;
        }
        .loading-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 1rem;
            opacity: 0;
            animation: slideInUp 1s ease-out 1.1s forwards;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loading-dots {
            display: inline-flex;
            gap: 0.5rem;
            margin-left: 0.5rem;
        }
        .loading-dot {
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            animation: loadingDots 1.5s ease-in-out infinite;
        }
        .loading-dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        .loading-dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        /* ==============================================
                MAIN CONTENT
                ============================================== */
        .main-content {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .main-content.show {
            opacity: 1;
        }
        /* ==============================================
                HERO SECTION
                ============================================== */
        .hero-section {
            background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--primary-bg) 100%);
            border-radius: 32px;
            padding: 5rem 3rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-color);
            min-height: 70vh;
            display: flex;
            align-items: center;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.02) 0%, transparent 50%);
            pointer-events: none;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: linear-gradient(45deg, transparent 40%, rgba(255, 255, 255, 0.02) 50%, transparent 60%);
            animation: heroShine 8s ease-in-out infinite;
            pointer-events: none;
        }
        /* Floating Mockup */
        .hero-mockup {
            position: absolute;
            right: -80px;
            bottom: -100px;
            width: 550px;
            height: 450px;
            background: url("{{ asset('storage/avatars/mockupavatar.png') }}") center/cover no-repeat;
            border-radius: 16px;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.5);
            transform: rotate(8deg);
            opacity: 0.95;
            animation: floatMockup 6s ease-in-out infinite;
            z-index: 0;
            filter: brightness(0.9) contrast(1.1);
        }
        @keyframes floatMockup {
            0%,
            100% {
                transform: rotate(8deg) translateY(0px);
            }
            50% {
                transform: rotate(10deg) translateY(-20px);
            }
        }
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--accent);
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            letter-spacing: 0.5px;
        }
        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 70%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            letter-spacing: -1px;
        }
        .hero-subtitle {
            font-size: 1.375rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            line-height: 1.6;
            font-weight: 400;
        }
        .hero-cta {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }
        /* ==============================================
                STATS SECTION
                ============================================== */
        .stats-section {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 0.8rem;
            margin-top: 18rem;
            margin-bottom: 5rem;
            position: relative;
            overflow: hidden;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
            pointer-events: none;
        }
        .stat-item {
            text-align: center;
            position: relative;
            transition: transform 0.3s ease;
        }
        .stat-item:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 3rem;
            font-weight: 600;
            color: var(--accent);
            display: block;
            margin-bottom: 0.5rem;
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }
        .stat-label {
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.1em;
        }
        /* ==============================================
                FEATURED CAROUSEL SECTION
                ============================================== */
        .featured-carousel-section {
            margin-bottom: 6rem;
            position: relative;
        }
        .carousel-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* .carousel-container:hover {
            border-color: var(--hover);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 30px rgba(255, 255, 255, 0.1);
        } */
        .carousel-content {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-item {
            min-width: 100%;
            padding: 0 2rem;
            box-sizing: border-box;
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.5s ease;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .carousel-item.active {
            opacity: 1;
            transform: scale(1);
        }
        .carousel-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }
        .carousel-nav {
            display: flex;
            gap: 1rem;
        }
        .nav-btn {
            width: 40px;
            height: 40px;
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .nav-btn:hover {
            background: var(--accent);
            color: var(--primary-bg);
            transform: scale(1.1);
        }
        .progress-container {
            flex: 1;
            height: 4px;
            background: var(--secondary-bg);
            border-radius: 2px;
            margin: 0 1rem;
            overflow: hidden;
            position: relative;
        }
        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent) 0%, var(--text-secondary) 100%);
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .carousel-indicators {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            justify-content: center;
        }
        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .indicator.active {
            background: var(--accent);
            transform: scale(1.2);
        }
        /* ==============================================
                HOW IT WORKS SECTION
                ============================================== */
        .how-it-works-section {
            margin-bottom: 6rem;
        }
        .step-container {
            position: relative;
        }
        .step-line {
            position: absolute;
            top: 40px;
            left: 50%;
            width: 2px;
            height: calc(100% - 80px);
            background: linear-gradient(to bottom, var(--accent), var(--border-color));
            transform: translateX(-50%);
            z-index: 0;
        }
        .step-item {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .step-item:hover {
            border-color: var(--accent);
            transform: translateX(8px) scale(1.01);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        .step-number {
            width: 60px;
            height: 60px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-bg);
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .step-number::before {
            content: '';
            position: absolute;
            width: 80px;
            height: 80px;
            border: 2px solid var(--accent);
            border-radius: 50%;
            opacity: 0.3;
            animation: pulse 2s ease-in-out infinite;
        }
        .step-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        .step-description {
            color: var(--text-secondary);
            line-height: 1.6;
        }
        .modern-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, transparent 50%);
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .modern-card:hover {
            transform: translateY(-8px);
            border-color: var(--hover);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 30px rgba(255, 255, 255, 0.1);
            background: var(--card-bg);
        }
        .modern-card:hover::before {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
        }
        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--text-secondary) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            color: var(--primary-bg);
            font-size: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }
        .modern-card:hover .card-icon {
            transform: scale(1.05);
        }
        .card-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .modern-card:hover .card-icon::before {
            left: 100%;
        }
        .card-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.375rem;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }
        .modern-card:hover .card-title {
            color: var(--accent);
        }
        .card-text {
            color: var(--text-secondary);
            line-height: 1.7;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        
        /* ==============================================
                TESTIMONIALS SECTION
                ============================================== */
        .testimonials-section {
            margin-bottom: 6rem;
            position: relative;
        }
        .testimonial-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            height: 100%;
            position: relative;
            transition: all 0.3s ease;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .testimonial-card:hover {
            transform: translateY(-4px) rotate(1deg);
            border-color: var(--hover);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        .testimonial-content {
            font-style: italic;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 2rem;
            font-size: 1.125rem;
            position: relative;
            padding-left: 1.5rem;
        }
        .testimonial-content::before {
            content: "";
            position: absolute;
            left: 0;
            top: -10px;
            font-size: 5rem;
            color: var(--accent);
            opacity: 0.1;
            font-family: Georgia, serif;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .author-avatar#sarah-testimonial {
            background: url('{{ asset('storage/avatars/sarahavatar.png') }}') center/cover no-repeat;
        }
        .author-avatar#mede-testimonial {
            background: url('{{ asset('storage/avatars/michael.png') }}') center/cover no-repeat;
        }
        .author-avatar#ali-testimonial {
            background: url('{{ asset('storage/avatars/mykisah.png') }}') center/cover no-repeat;
        }
        .author-info h6 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .author-info h6::after {
            font-size: 0.8rem;
            opacity: 0.7;
        }
        .author-info p {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin: 0;
        }
        .quote-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 2rem;
            color: var(--accent);
            opacity: 0.1;
            transition: opacity 0.3s ease;
        }
        .testimonial-card:hover .quote-icon {
            opacity: 0.2;
        }
        /* ==============================================
                PRICING PREVIEW SECTION
                ============================================== */
        .pricing-preview-section {
            margin-bottom: 6rem;
        }
        .pricing-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            text-align: center;
            position: relative;
            height: 100%;
            transition: all 0.3s ease;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .pricing-card.featured {
            border-color: var(--accent);
            transform: scale(1.05);
            animation: pulseFeatured 4s ease-in-out infinite;
        }
        @keyframes pulseFeatured {
            0%,
            100% {
                transform: scale(1.05);
            }
            50% {
                transform: scale(1.07);
            }
        }
        .pricing-card.featured::before {
            content: 'Most Popular';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--accent);
            color: var(--primary-bg);
            padding: 0.5rem 2rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        /* Add Trial Ribbon */
        .pricing-card::after {
            content: '7-Day Free Trial';
            position: absolute;
            top: 15px;
            right: -30px;
            background: var(--text-secondary);
            color: var(--primary-bg);
            padding: 0.25rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            transform: rotate(45deg);
            opacity: 0.9;
        }
        .pricing-card:hover {
            transform: translateY(-4px);
            border-color: var(--hover);
        }
        .pricing-card.featured:hover {
            transform: translateY(-4px) scale(1.05);
        }
        .pricing-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        .pricing-price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }
        .pricing-price .currency {
            font-size: 1.5rem;
            vertical-align: top;
        }
        .pricing-period {
            color: var(--text-muted);
            margin-bottom: 2rem;
        }
        .pricing-features {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
        }
        .pricing-features li {
            color: var(--text-secondary);
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: color 0.3s ease;
        }
        .pricing-card:hover .pricing-features li {
            color: var(--text-primary);
        }
        .pricing-features li:last-child {
            border-bottom: none;
        }
        .pricing-features li i {
            color: var(--accent);
            margin-right: 0.75rem;
            transition: transform 0.3s ease;
        }
        .pricing-card:hover .pricing-features li i {
            transform: scale(1.1);
        }
        
        /* ==============================================
                BUTTONS
                ============================================== */
        .modern-btn {
            padding: 1rem 2.5rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .modern-btn:hover::before {
            left: 100%;
        }
        .btn-primary-modern {
            background: linear-gradient(135deg, var(--accent) 0%, var(--text-secondary) 100%);
            color: var(--primary-bg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .btn-primary-modern:hover {
            background: linear-gradient(135deg, var(--text-secondary) 0%, var(--accent) 100%);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        .btn-outline-modern {
            background: transparent;
            color: var(--text-primary);
            border: 2px solid var(--border-color);
            backdrop-filter: blur(10px);
        }
        .btn-outline-modern:hover {
            background: var(--hover);
            border-color: var(--accent);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-3px);
        }
        .btn-lg {
            padding: 1.25rem 3rem;
            font-size: 1.125rem;
        }
        /* ==============================================
                SECTION UTILITIES
                ============================================== */
        .section-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-align: center;
            color: var(--text-primary);
            position: relative;
            letter-spacing: -0.5px;
        }
        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 4rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        .section-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--text-secondary));
            border-radius: 2px;
            margin: 0 auto 3rem;
        }
        /* ==============================================
                TEAM SECTION (REAL PHOTOS)
                ============================================== */
        .team-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .team-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, transparent 50%);
            pointer-events: none;
            transition: all 0.3s ease;
        }
        .team-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: var(--hover);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .team-card:hover::before {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        }
        .team-avatar {
            width: 100px;
            height: 100px;
            border: 3px solid var(--border-color);
            border-radius: 50%;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: breathe 6s ease-in-out infinite;
        }
        #ali-team {
            background: url("{{ asset('storage/avatars/Aliavatar.jpg') }}") center/cover no-repeat;
        }
        #mede-team {
            background: url("{{ asset('storage/avatars/Medeavatar.png') }}") center/cover no-repeat;
        }
        .team-name {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.375rem;
            margin-bottom: 0.5rem;
        }
        .team-role {
            color: var(--accent);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .team-bio {
            color: var(--text-secondary);
            line-height: 1.6;
        }
        .team-social {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .team-card:hover .team-social {
            opacity: 1;
        }
        .team-social a {
            color: var(--text-secondary);
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }
        .team-social a:hover {
            color: var(--accent);
        }
        /* ==============================================
                CONTACT SECTION
                ============================================== */
        .contact-section {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 32px;
            padding: 4rem;
            margin-top: 6rem;
            position: relative;
            overflow: hidden;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .contact-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }
        .contact-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .contact-info:hover {
            border-color: var(--accent);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .contact-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--accent), var(--text-secondary));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-bg);
            font-size: 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .contact-details h6 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }
        .contact-details p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 1rem;
        }
        /* ==============================================
                CTA SECTION
                ============================================== */
        .cta-section {
            background: linear-gradient(135deg, var(--card-bg) 0%, var(--secondary-bg) 100%);
            border: 1px solid var(--border-color);
            border-radius: 32px;
            padding: 4rem;
            text-align: center;
            margin-top: 6rem;
            position: relative;
            overflow: hidden;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            letter-spacing: -0.5px;
        }
        .cta-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            line-height: 1.6;
        }
        /* ==============================================
            CERTIFICATIONS MARQUEE
            ============================================== */
        .certifications-marquee-section {
            margin: 2rem 0;
            width: 100%;
            overflow: hidden;
            background: transparent;
            position: absolute;
            left: 0;
            right: 0;
            pointer-events: none;
        }

        .certifications-marquee {
            width: 100%;
            position: relative;
            padding: 2rem 0;
        }

        .marquee-track {
            width: 100%;
            overflow: hidden;
        }

        .marquee-content {
            display: flex;
            align-items: center;
            justify-content: space-around;
            gap: 4rem;
            animation: marquee 30s linear infinite;
            width: 200%;
        }

        .marquee-image {
            height: 110px;
            width: auto;
            opacity: 0.7;
            transition: all 0.3s ease;
            pointer-events: auto;
        }

        .marquee-image:hover {
            opacity: 1;
            filter: grayscale(0%);
            transform: scale(1.05);
        }
        /* ==============================================
                ANIMATIONS
                ============================================== */
        @keyframes logoFloat {
            0%,
            100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }
        @keyframes logoRing {
            0% {
                transform: rotate(0deg);
                opacity: 0.6;
            }
            50% {
                opacity: 0.3;
            }
            100% {
                transform: rotate(360deg);
                opacity: 0.6;
            }
        }
        @keyframes logoIcon {
            0%,
            100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes loadingProgress {
            from {
                width: 0%;
            }
            to {
                width: 100%;
            }
        }
        @keyframes loadingDots {
            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
        }
        @keyframes heroShine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            50% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
            100% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.1;
            }
            100% {
                transform: scale(1);
                opacity: 0.3;
            }
        }
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes breathe {
            0%,
            100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }
        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        /* ==============================================
                RESPONSIVE DESIGN
                ============================================== */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 3.5rem;
            }
            .section-title {
                font-size: 2.5rem;
            }
            .hero-mockup {
                display: none;
            }
        }
        @media (max-width: 992px) {
            .hero-section {
                padding: 4rem 2rem;
                min-height: 60vh;
            }
            .hero-title {
                font-size: 3rem;
            }
            .hero-subtitle {
                font-size: 1.25rem;
            }
            .section-title {
                font-size: 2.25rem;
            }
            .modern-btn {
                width: 100%;
                margin-bottom: 1rem;
            }
            .hero-cta {
                flex-direction: column;
            }
            .step-item:hover {
                transform: translateY(-4px);
            }
            .step-line {
                display: none;
            }
            .contact-section {
                padding: 3rem 2rem;
            }
            .cta-section {
                padding: 3rem 2rem;
            }
            .stats-section {
                padding: 2rem;
            }
            .pricing-card.featured {
                transform: none;
            }
            .pricing-card.featured:hover {
                transform: translateY(-4px);
            }
            .carousel-controls {
                flex-direction: column;
                gap: 1rem;
            }
            .progress-container {
                margin: 1rem 0;
                width: 100%;
            }
        }
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.125rem;
            }
            .hero-section {
                padding: 3rem 1.5rem;
                min-height: 50vh;
            }
            .section-title {
                font-size: 2rem;
            }
            .section-subtitle {
                font-size: 1.125rem;
            }
            .modern-card {
                padding: 2rem;
            }
            .team-card {
                padding: 2rem;
            }
            .contact-info {
                flex-direction: column;
                text-align: center;
            }
            .stats-section {
                padding: 2rem 1rem;
            }
            .contact-section {
                padding: 2rem 1rem;
            }
            .cta-section {
                padding: 2rem 1rem;
            }
            .cta-title {
                font-size: 2rem;
            }
            .stat-number {
                font-size: 2.5rem;
            }
            .card-icon {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }
            .team-avatar {
                width: 80px;
                height: 80px;
            }
            .pricing-price {
                font-size: 2.5rem;
            }
            .carousel-container {
                padding: 1.5rem;
            }
        }
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2.25rem;
            }
            .section-title {
                font-size: 1.75rem;
            }
            .modern-btn {
                padding: 1rem 2rem;
                font-size: 0.875rem;
            }
            .loading-logo {
                width: 100px;
                height: 100px;
            }
            .loading-logo::before {
                width: 120px;
                height: 120px;
            }
            .loading-logo i {
                font-size: 2.5rem;
            }
            .loading-title {
                font-size: 2rem;
            }
            .nav-btn {
                width: 32px;
                height: 32px;
            }
        }
    </style>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-container">
            <div class="loading-logo">
                <i class="fa fa-graduation-cap"></i>
            </div>
            <h1 class="loading-title">Xperium Academy</h1>
            <p class="loading-subtitle">Preparing your learning experience</p>
            <div class="loading-progress">
                <div class="loading-bar" id="loadingBar"></div>
                <div class="loading-percent" id="loadingPercent">0%</div>
            </div>
            <div class="loading-text">
                Loading
                <span class="loading-dots">
                    <span class="loading-dot"></span>
                    <span class="loading-dot"></span>
                    <span class="loading-dot"></span>
                </span>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-mockup"></div>
            <div class="hero-content text-center">
                <div class="hero-badge">
                    <i class="fa fa-star"></i>
                    Trusted by 50,000+ learners worldwide
                </div>
                <h1 class="hero-title">Master New Skills with Expert-Led Courses</h1>
                <p class="hero-subtitle">Transform your career and unlock your potential with our comprehensive learning
                    platform. Join thousands of successful learners who've already taken the leap.</p>
                <div class="hero-cta">
                    <a class="modern-btn btn-primary-modern btn-lg" href="{{ route('public.courses.index') }}"
                        role="button">
                        <i class="fa fa-rocket"></i>
                        Start Learning Today
                    </a>
                    @guest
                        <a class="modern-btn btn-outline-modern btn-lg" href="{{ route('register') }}" role="button">
                            <i class="fa fa-user-plus"></i>
                            Join Free Now
                        </a>
                    @endguest
                </div>
            </div>
        </section>
        <!-- Certifications Marquee Section -->
        <section class="certifications-marquee-section">
            <div class="certifications-marquee">
                <div class="marquee-track">
                    <div class="marquee-content">
                        <img src="{{ asset('storage/certificates/aws.png') }}" alt="AWS Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/googlecloud.png') }}" alt="Google Cloud Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/azure.png') }}" alt="Microsoft Azure Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/comptia.png') }}" alt="CompTIA Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/cisco.png') }}" alt="Cisco Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/oracle.png') }}" alt="Oracle Certification"
                            class="marquee-image">
                        <!-- Duplicatet for seamless loop -->
                        <img src="{{ asset('storage/certificates/aws.png') }}" alt="AWS Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/googlecloud.png') }}" alt="Google Cloud Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/azure.png') }}" alt="Microsoft Azure Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/comptia.png') }}" alt="CompTIA Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/cisco.png') }}" alt="Cisco Certification"
                            class="marquee-image">
                        <img src="{{ asset('storage/certificates/oracle.png') }}" alt="Oracle Certification"
                            class="marquee-image">
                    </div>
                </div>
            </div>
        </section>
        <!-- Stats Section -->
        <section class="stats-section">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="50000">0</span>
                        <div class="stat-label">Active Students</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="1200">0</span>
                        <div class="stat-label">Expert Courses</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="150">0</span>
                        <div class="stat-label">Industry Experts</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="98">0</span>
                        <div class="stat-label">Success Rate %</div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Featured Carousel Section -->
        <section class="featured-carousel-section">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Choose Our Platform?</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">We've designed every aspect of our platform to provide you with the most
                    effective and engaging learning experience possible.</p>
            </div>
            <div class="carousel-container">
                <div class="carousel-content" id="carouselContent">
                    <!-- Item 1 -->
                    <div class="carousel-item active">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--accent); margin-bottom: 2rem;">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <h3 class="section-title" style="font-size: 2.5rem;">Flexible Learning</h3>
                            <p class="section-subtitle" style="max-width: 800px;">Learn at your own pace with 24/7 access to
                                course materials. Our platform adapts to your schedule, not the other way around.</p>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div class="carousel-item">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--accent); margin-bottom: 2rem;">
                                <i class="fa fa-users"></i>
                            </div>
                            <h3 class="section-title" style="font-size: 2.5rem;">Expert Instructors</h3>
                            <p class="section-subtitle" style="max-width: 800px;">Learn directly from industry professionals
                                with years of real-world experience in their respective fields.</p>
                        </div>
                    </div>
                    <!-- Item 3 -->
                    <div class="carousel-item">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--accent); margin-bottom: 2rem;">
                                <i class="fa fa-certificate"></i>
                            </div>
                            <h3 class="section-title" style="font-size: 2.5rem;">Recognized Certificates</h3>
                            <p class="section-subtitle" style="max-width: 800px;">Earn industry-recognized certificates upon
                                completion that boost your career prospects and professional credibility.</p>
                        </div>
                    </div>
                    <!-- Item 4 -->
                    <div class="carousel-item">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--accent); margin-bottom: 2rem;">
                                <i class="fa fa-mobile"></i>
                            </div>
                            <h3 class="section-title" style="font-size: 2.5rem;">Mobile Learning</h3>
                            <p class="section-subtitle" style="max-width: 800px;">Access your courses anywhere, anytime with
                                our mobile-optimized platform. Learn on the go without missing a beat.</p>
                        </div>
                    </div>
                    <!-- Item 5 -->
                    <div class="carousel-item">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--accent); margin-bottom: 2rem;">
                                <i class="fa fa-comments"></i>
                            </div>
                            <h3 class="section-title" style="font-size: 2.5rem;">Community Support</h3>
                            <p class="section-subtitle" style="max-width: 800px;">Connect with fellow learners, participate
                                in discussions, and get help from our vibrant learning community.</p>
                        </div>
                    </div>
                    <!-- Item 6 -->
                    <div class="carousel-item">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--accent); margin-bottom: 2rem;">
                                <i class="fa fa-shield"></i>
                            </div>
                            <h3 class="section-title" style="font-size: 2.5rem;">Secure & Reliable</h3>
                            <p class="section-subtitle" style="max-width: 800px;">Your data and progress are protected with
                                enterprise-grade security. Focus on learning while we handle the rest.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-controls">
                    <div class="carousel-nav">
                        <button class="nav-btn" id="prevBtn">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <button class="nav-btn" id="nextBtn">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" id="carouselProgress"></div>
                    </div>
                    <div class="carousel-indicators" id="carouselIndicators">
                        <span class="indicator active" data-index="0"></span>
                        <span class="indicator" data-index="1"></span>
                        <span class="indicator" data-index="2"></span>
                        <span class="indicator" data-index="3"></span>
                        <span class="indicator" data-index="4"></span>
                        <span class="indicator" data-index="5"></span>
                    </div>
                </div>
            </div>
        </section>
        <!-- How It Works Section -->
        <section class="how-it-works-section">
            <div class="text-center mb-5">
                <h2 class="section-title">How It Works</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Getting started is simple. Follow these easy steps to begin your learning
                    journey today.</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="step-container">
                        <div class="step-line d-none d-lg-block"></div>
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h5 class="step-title">Browse & Choose</h5>
                            <p class="step-description">Explore our extensive catalog of courses across various categories.
                                Filter by skill level, duration, and topic to find the perfect match for your goals.</p>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h5 class="step-title">Enroll & Start</h5>
                            <p class="step-description">Once you've found your ideal course, enroll with just a few clicks.
                                Get instant access to all course materials and begin learning immediately.</p>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h5 class="step-title">Learn & Progress</h5>
                            <p class="step-description">Follow the structured curriculum, complete assignments, and track
                                your progress. Engage with instructors and peers for a richer learning experience.</p>
                        </div>
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h5 class="step-title">Earn & Apply</h5>
                            <p class="step-description">Complete your course, earn your certificate, and apply your new
                                skills in real-world scenarios. Advance your career with confidence.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="modern-card"
                        style="height: 100%; display: flex; align-items: center; justify-content: center; min-height: 500px;">
                        <div class="text-center">
                            <div style="font-size: 8rem; color: var(--accent); opacity: 0.3; margin-bottom: 2rem;">
                                <i class="fa fa-graduation-cap"></i>
                            </div>
                            <h4 style="color: var(--text-primary); margin-bottom: 1rem;">Ready to Get Started?</h4>
                            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Join thousands of learners who are
                                already transforming their careers with our platform.</p>
                            <a href="{{ route('public.courses.index') }}" class="modern-btn btn-primary-modern">
                                <i class="fa fa-arrow-right"></i>
                                Explore Courses
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            

        <!-- Testimonials Section -->
        <section class="testimonials-section">
            <div class="text-center mb-5">
                <h2 class="section-title">What Our Students Say</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Don't just take our word for it. Hear from some of our successful students
                    who've transformed their careers through our platform.</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fa fa-quote-right"></i>
                        </div>
                        <div class="testimonial-content">
                            "This platform completely changed my approach to learning. The courses are well-structured, and
                            the instructors genuinely care about your success. I landed my dream job within 3 months of
                            completing my course!"
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" id="sarah-testimonial"></div>
                            <div class="author-info">
                                <h6>Sarah Johnson</h6>
                                <p>Web Developer at Tech Corp</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fa fa-quote-right"></i>
                        </div>
                        <div class="testimonial-content">
                            "The flexibility of this platform allowed me to upskill while working full-time. The mobile app
                            is fantastic, and I could learn during my commute. Highly recommend to anyone looking to advance
                            their career."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" id="mede-testimonial"></div>
                            <div class="author-info">
                                <h6>Michael Rodriguez</h6>
                                <p>Digital Marketing Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fa fa-quote-right"></i>
                        </div>
                        <div class="testimonial-content">
                            "As someone new to programming, I was intimidated at first. But the step-by-step approach and
                            supportive community made all the difference. I'm now confident in my coding abilities and
                            working on exciting projects."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" id="ali-testimonial"></div>
                            <div class="author-info">
                                <h6>Emily Liu</h6>
                                <p>Junior Software Engineer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Pricing Preview Section -->
        <section class="pricing-preview-section">
            <div class="text-center mb-5">
                <h2 class="section-title">Simple, Transparent Pricing</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Choose the plan that works best for you. All plans include access to our full
                    course library and community features.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="pricing-card">
                        <h5 class="pricing-title">Basic</h5>
                        <div class="pricing-price">
                            <span class="currency">Rp.</span>99.000
                        </div>
                        <div class="pricing-period">per month</div>
                        <ul class="pricing-features">
                            <li><i class="fa fa-check"></i> Access to 100+ courses</li>
                            <li><i class="fa fa-check"></i> Mobile learning app</li>
                            <li><i class="fa fa-check"></i> Community forums</li>
                            <li><i class="fa fa-check"></i> Basic certificates</li>
                            <li><i class="fa fa-times" style="color: var(--text-muted);"></i> 1-on-1 mentoring</li>
                        </ul>
                        <a href="#" class="modern-btn btn-outline-modern">
                            Get Started
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="pricing-card featured">
                        <h5 class="pricing-title">Professional</h5>
                        <div class="pricing-price">
                            <span class="currency">Rp.</span>129.000
                        </div>
                        <div class="pricing-period">per month</div>
                        <ul class="pricing-features">
                            <li><i class="fa fa-check"></i> Access to all 1200+ courses</li>
                            <li><i class="fa fa-check"></i> Mobile learning app</li>
                            <li><i class="fa fa-check"></i> Priority community support</li>
                            <li><i class="fa fa-check"></i> Verified certificates</li>
                            <li><i class="fa fa-check"></i> Monthly 1-on-1 mentoring</li>
                        </ul>
                        <a href="#" class="modern-btn btn-primary-modern">
                            Most Popular
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="pricing-card">
                        <h5 class="pricing-title">Enterprise</h5>
                        <div class="pricing-price">
                            <span class="currency">Rp.</span>189.000
                        </div>
                        <div class="pricing-period">per month</div>
                        <ul class="pricing-features">
                            <li><i class="fa fa-check"></i> Everything in Professional</li>
                            <li><i class="fa fa-check"></i> Custom learning paths</li>
                            <li><i class="fa fa-check"></i> Team management tools</li>
                            <li><i class="fa fa-check"></i> Advanced analytics</li>
                            <li><i class="fa fa-check"></i> Dedicated account manager</li>
                        </ul>
                        <a href="#" class="modern-btn btn-outline-modern">
                            Contact Sales
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team Section -->
        <section class="mb-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Meet Our Team</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Behind every great platform is a passionate team dedicated to transforming
                    education and empowering learners worldwide.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="team-card">
                        <div class="team-avatar" id="ali-team"></div>
                        <h5 class="team-name">Muhammad Ali Irfansyah</h5>
                        <p class="team-role">Founder & Lead Developer</p>
                        <p class="team-bio">Passionate full-stack developer with a vision to revolutionize online education.
                            Dedicated to creating innovative solutions that make learning accessible and engaging for
                            everyone.</p>
                        <div class="team-social">
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-github"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="team-card">
                        <div class="team-avatar" id="mede-team"></div>
                        <h5 class="team-name">Rakha Maide</h5>
                        <p class="team-role">Content & Curriculum Specialists</p>
                        <p class="team-bio">Our diverse team of educators, instructional designers, and subject matter
                            experts work tirelessly to curate high-quality courses that deliver real-world value to our
                            learners.</p>
                        <div class="team-social">
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Section -->
        <section>
            <div class="contact-section">
                <div class="text-center mb-5">
                    <h2 class="section-title">Get In Touch</h2>
                    <div class="section-divider"></div>
                    <p class="section-subtitle">Have questions or need support? We're here to help you on your learning
                        journey.</p>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h6>Email Support</h6>
                                <p>support@booking.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h6>Phone Support</h6>
                                <p>+62 123 456 7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="contact-details">
                                <h6>Our Location</h6>
                                <p>Jakarta, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @guest
            <!-- CTA Section -->
            <section class="cta-section">
                <h3 class="cta-title">Ready to Transform Your Career?</h3>
                <p class="cta-subtitle">Join our community of successful learners and take the first step towards achieving your
                    professional goals with expert-led courses and personalized learning paths.</p>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('register') }}" class="modern-btn btn-primary-modern btn-lg">
                            <i class="fa fa-user-plus"></i>
                            Create Free Account
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('login') }}" class="modern-btn btn-outline-modern btn-lg">
                            <i class="fa fa-sign-in"></i>
                            Sign In
                        </a>
                    </div>
                </div>
            </section>
        @endguest
    </div> <!-- End Main Content -->
    <script>
        // Loading Screen & Animation Script
        document.addEventListener('DOMContentLoaded', function () {
            const loadingScreen = document.getElementById('loadingScreen');
            const mainContent = document.getElementById('mainContent');
            const loadingBar = document.getElementById('loadingBar');
            const loadingPercent = document.getElementById('loadingPercent');
            const minLoadingTime = 3000;
            let pageLoaded = false;
            let timeElapsed = false;
            let progress = 0;
            const progressInterval = setInterval(() => {
                if (progress >= 100) clearInterval(progressInterval);
                progress += Math.random() * 3;
                if (progress > 100) progress = 100;
                loadingBar.style.width = progress + '%';
                loadingPercent.textContent = Math.floor(progress) + '%';
            }, 100);
            function checkReady() {
                if (pageLoaded && timeElapsed) {
                    hideLoading();
                }
            }
            function hideLoading() {
                clearInterval(progressInterval);
                loadingScreen.classList.add('fade-out');
                setTimeout(() => {
                    mainContent.classList.add('show');
                    loadingScreen.style.display = 'none';
                    initAnimations();
                }, 800);
            }
            // Init scroll animations and counters
            function initAnimations() {
                // Animate counters
                animateCounters();
                // Setup scroll animations
                setupScrollAnimations();
                // Initialize carousel
                initCarousel();
            }
            // Counter animation
            function animateCounters() {
                const counters = document.querySelectorAll('.stat-number');
                const duration = 4000; // 4 seconds
                counters.forEach(counter => {
                    const target = parseInt(counter.dataset.count);
                    const startTime = performance.now();
                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const updateCounter = (currentTime) => {
                                    const elapsed = currentTime - startTime;
                                    const progress = Math.min(elapsed / duration, 1);
                                    const value = target * progress;
                                    counter.textContent = Math.floor(value).toLocaleString();
                                    if (progress < 1) {
                                        requestAnimationFrame(updateCounter);
                                    } else {
                                        counter.textContent = target.toLocaleString();
                                    }
                                };
                                requestAnimationFrame(updateCounter);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.5 });
                    observer.observe(counter);
                });
            }
            // Scroll animations
            function setupScrollAnimations() {
                const animateElements = document.querySelectorAll('.modern-card, .step-item, .testimonial-card, .pricing-card, .team-card');
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.animation = 'fadeInScale 0.6s ease-out forwards';
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                animateElements.forEach(el => {
                    el.style.opacity = '0';
                    observer.observe(el);
                });
            }
            // Carousel functionality
            function initCarousel() {
                const carouselContent = document.getElementById('carouselContent');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const indicators = document.querySelectorAll('.indicator');
                const progressBar = document.getElementById('carouselProgress');
                let currentIndex = 0;
                const totalItems = 6;
                let autoPlayInterval;
                function updateCarousel(index) {
                    // Update current index
                    currentIndex = index;
                    // Update carousel position
                    carouselContent.style.transform = `translateX(-${currentIndex * 100}%)`;
                    // Update indicators
                    indicators.forEach((indicator, i) => {
                        if (i === currentIndex) {
                            indicator.classList.add('active');
                        } else {
                            indicator.classList.remove('active');
                        }
                    });
                    // Update progress bar
                    progressBar.style.width = `${(currentIndex / (totalItems - 1)) * 100}%`;
                    // Update active class for animation
                    document.querySelectorAll('.carousel-item').forEach((item, i) => {
                        if (i === currentIndex) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                }
                function nextSlide() {
                    let nextIndex = currentIndex + 1;
                    if (nextIndex >= totalItems) {
                        nextIndex = 0;
                    }
                    updateCarousel(nextIndex);
                }
                function prevSlide() {
                    let prevIndex = currentIndex - 1;
                    if (prevIndex < 0) {
                        prevIndex = totalItems - 1;
                    }
                    updateCarousel(prevIndex);
                }
                // Event listeners
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    resetAutoPlay();
                });
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    resetAutoPlay();
                });
                // Indicator click events
                indicators.forEach(indicator => {
                    indicator.addEventListener('click', () => {
                        const index = parseInt(indicator.dataset.index);
                        updateCarousel(index);
                        resetAutoPlay();
                    });
                });
                // Auto play
                function startAutoPlay() {
                    autoPlayInterval = setInterval(nextSlide, 5000);
                }
                function resetAutoPlay() {
                    clearInterval(autoPlayInterval);
                    startAutoPlay();
                }
                // Start auto play
                startAutoPlay();
                // Pause on hover
                const carouselContainer = document.querySelector('.carousel-container');
                carouselContainer.addEventListener('mouseenter', () => {
                    clearInterval(autoPlayInterval);
                });
                carouselContainer.addEventListener('mouseleave', () => {
                    startAutoPlay();
                });
            }
            // Timing controls
            setTimeout(() => {
                timeElapsed = true;
                checkReady();
            }, minLoadingTime);
            window.addEventListener('load', () => {
                pageLoaded = true;
                checkReady();
            });
            // Fallback
            setTimeout(() => {
                if (!loadingScreen.classList.contains('fade-out')) {
                    hideLoading();
                }
            }, 6000);
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endsection